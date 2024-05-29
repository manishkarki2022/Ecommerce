<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Artesaos\SEOTools\Facades\SEOTools as SEO;

class ShopController extends Controller
{


    public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
    {
        $categorySelected = '';
        $subCategorySelected = '';

        $categories = Category::orderBy('name', 'asc')
            ->with('subCategories')
            ->where('status', 1)
            ->get();

        $productsQuery = Product::where('status', 1);

        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $productsQuery->where('category_id', $category->id);
            $categorySelected = $category->id;

            // Set SEO for the category
            SEO::setTitle($category->name . " Books");
            SEO::setDescription("Explore a wide range of " . $category->name . " books available in our bookshop.");
            SEO::metatags()->addMeta('keywords', $category->name . ' books, buy ' . $category->name . ' books, ' . $category->name . ' literature');
            SEO::opengraph()->setUrl(route('front.shop', ['categorySlug' => $categorySlug]));
            SEO::opengraph()->addProperty('type', 'website');
//            SEO::opengraph()->addImage(asset('path/to/category/image.jpg'));
            SEO::twitter()->setSite('@LuizVinicius73');
        }

        if (!empty($subCategorySlug)) {
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $productsQuery->where('sub_category_id', $subCategory->id);
            $subCategorySelected = $subCategory->id;

            // Set SEO for the sub-category
            SEO::setTitle($subCategory->name . " Books");
            SEO::setDescription("Explore a wide range of " . $subCategory->name . " books available in our bookshop.");
            SEO::metatags()->addMeta('keywords', $subCategory->name . ' books, buy ' . $subCategory->name . ' books, ' . $subCategory->name . ' literature');
            SEO::opengraph()->setUrl(route('front.shop', ['categorySlug' => $categorySlug, 'subCategorySlug' => $subCategorySlug]));
            SEO::opengraph()->addProperty('type', 'website');
//            SEO::opengraph()->addImage(asset('path/to/subcategory/image.jpg'));
            SEO::twitter()->setSite('@LuizVinicius73');
        }

        // Price range filter
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $price_min = (int)$request->input('price_min');
            $price_max = (int)$request->input('price_max');

            if ($price_min <= $price_max) {
                $productsQuery->whereBetween('price', [$price_min, $price_max]);
            }
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'latest':
                    $productsQuery->orderBy('id', 'desc');
                    break;
                case 'price_asc':
                    $productsQuery->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $productsQuery->orderBy('price', 'desc');
                    break;
                default:
                    // Handle invalid sorting option
                    break;
            }
        }

        // Search filter
        if (!empty($request->get('search'))) {
            $searchTerm = $request->input('search');

            $productsQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('ebook', 'like', '%' . $searchTerm . '%')
                    ->orWhere('isbn_number', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('author', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('subCategory', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhere('price', 'like', '%' . $searchTerm . '%');
            });

            // Set SEO for search filter
            SEO::setTitle('Search results for: ' . $searchTerm);
            SEO::setDescription('Browse our books matching the search term: ' . $searchTerm);
            SEO::metatags()->addMeta('keywords', $searchTerm . ' books, buy ' . $searchTerm . ' books');
            SEO::opengraph()->setUrl(route('front.shop', ['search' => $searchTerm]));
            SEO::opengraph()->addProperty('type', 'website');
            SEO::twitter()->setSite('@LuizVinicius73');
        }

        $products = $productsQuery->latest()->paginate(12);
        $sortOption = $request->input('sort');

        // Set canonical URL
        SEO::metatags()->setCanonical(route('front.shop', $request->query()));

        return view('front.shop', compact('categories', 'products', 'categorySelected', 'subCategorySelected', 'sortOption'));
    }



    public function product($slug){
        $product = Product::where('slug', $slug)
            ->withCount('ratings')
            ->withSum('ratings', 'rating')
            ->with(['images','ratings'])->first();
           if (!$product) {
                abort(404);
            }
        $relatedProducts=[];

           //Average rating

        $avgRating = '0.00';
        $avgRatingPer = 0;
        if($product->ratings_count > 0){
            $avgRating = number_format($product->ratings_sum_rating / $product->ratings_count, 2);
            $avgRatingPer = ($avgRating*100) / 5;
        }


        if($product->related_products !=''){
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->with('images')->get();
        }
        SEO::setTitle($product->title);
        SEO::setDescription(giveSmoothText($product->short_description, 320));;
        SEO::opengraph()->setUrl(route('front.product',$product->slug));
        SEO::opengraph()->addProperty('type', 'website');
        SEO::twitter()->setSite('@LuizVinicius73');//

        return view('front.product', compact('product','relatedProducts','avgRating','avgRatingPer'));



    }
    public function productRating(Request $request){

         $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->back()->with('error', 'Product not found');
        }
        $count = ProductRating::where('product_id', $request->product_id)->where('email', $request->email)->count();
        if ($count > 0) {
            return redirect()->back()->with('error', 'You have already rated this product');
        }


        $rating = new ProductRating();
        $rating->product_id = $request->product_id;
        $rating->username = $request->name;
        $rating->email = $request->email;
        $rating->comment = $request->comment;
        $rating->rating = $request->rating;
        $rating->status = 0;
        $rating->save();
        return redirect()->back()->with('success', 'Rating added successfully');


    }




}
