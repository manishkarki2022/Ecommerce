<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
        }

        if (!empty($subCategorySlug)) {
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $productsQuery->where('sub_category_id', $subCategory->id);
            $subCategorySelected = $subCategory->id;
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
                // Add more sorting options if needed
                default:
                    // Handle invalid sorting option
                    break;
            }
        }
        $products = $productsQuery->paginate(12);
        $sortOption = $request->input('sort');

        return view('front.shop', compact('categories', 'products', 'categorySelected', 'subCategorySelected', 'sortOption'));
    }




}
