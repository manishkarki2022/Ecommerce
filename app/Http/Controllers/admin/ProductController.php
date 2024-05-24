<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\BookType;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductRating;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products= Product::latest()->paginate(10);
        return view('admin.products.index',compact('products') );

    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform the search query
        $products = Product::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('price', 'like', '%' . $keyword . '%')
            ->orWhere('sku', 'like', '%' . $keyword . '%')
            ->orWhere('qty', 'like', '%' . $keyword . '%')
            ->paginate(10);

        // Pass the search results to your view
        return view('admin.products.index', ['products' => $products]);
    }

    public function create(){
        $authors = Author::where('status', 'active')->orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $bookTypes = BookType::orderBy('name', 'asc')->get();
        return view('admin.products.create',compact('categories','bookTypes','authors') );

    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'compare_price' => 'nullable',
            'author_id' => 'required',
            'isbn_number' => 'nullable',
            'publisher_name' => 'nullable',
            'published_year' => 'nullable',
            'edition' => 'nullable',
            'country' => 'nullable',
            'language' => 'nullable',
            'pages' => 'nullable',
            'price' => 'nullable|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'nullable|in:Yes,No',
            'qty' => $request->filled('track_qty') ? 'required|numeric' : '',
            'category_id' => 'required|numeric',
            'is_featured' => 'nullable|in:Yes,No',
            'description' => 'nullable',
            'barcode' => 'nullable',
            'book_type_id' => 'required',
            'status' => 'required|in:0,1',
            'sub_category_id' => 'nullable|numeric',
            'short_description' => 'nullable',
            'shipping_returns' => 'nullable',
            'related_products' => 'nullable',
            'ebook_price' => 'nullable|numeric',
            'ebook_compare_price' => 'nullable|numeric',
            'ebook' => 'nullable|file|mimes:pdf,epub|mimetypes:application/pdf,application/epub+zip|max:30048',
        ]);
        // Add conditional rules based on book_type_id
        if (in_array($request->book_type_id, [1, 3])) {
            $validator->sometimes('ebook_price', 'required|numeric', function ($input) {
                return in_array($input->book_type_id, [1, 3]);
            });

            $validator->sometimes('ebook_compare_price', 'required|numeric', function ($input) {
                return in_array($input->book_type_id, [1, 3]);
            });

            $validator->sometimes('ebook', 'required|file|mimes:pdf,epub|mimetypes:application/pdf,application/epub+zip|max:30048', function ($input) {
                return in_array($input->book_type_id, [1, 3]);
            });
        }

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            session()->flash('error', implode('<br>', $errors));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = new Product($validator->validated());
        $product->related_products=(!empty($request->related_products)) ? implode(',',$request->related_products) : '';
        $product->save();

        // Save product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Validate the image
                $imageValidator = Validator::make(['image' => $image], [
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust maximum file size as needed
                ]);

                if ($imageValidator->fails()) {
                    // Handle validation failure
                    return redirect()->back()->withErrors($imageValidator)->withInput();
                }

                // Generate a unique file name
                $newName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

                // Move the uploaded image to the storage directory
                $image->move(public_path('products'), $newName);

                // Create a new record in the product_images table
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = $newName;
                $productImage->save();
            }
        }
        if ($request->hasFile('ebook')) {
            $ebook = $request->file('ebook');
            $ebookName = uniqid() . '_' . time() . '.' . $ebook->getClientOriginalExtension();
            $directory = 'ebooks/' . $product->id;

            // Store the ebook in the 'public' directory
            $ebook->move(public_path($directory), $ebookName);

            $productEbook = new Ebook();
            $productEbook->product_id = $product->id;

            // Store the relative path to the ebook file
            $productEbook->file_location = $directory . '/' . $ebookName;
            $productEbook->save();
            $request->session()->flash('success', 'Product created successfully.');
            return redirect()->route('products.index');
        } else {
            // If the book is not an ebook, show success message and redirect
            $request->session()->flash('success', 'Product created successfully.');
            return redirect()->route('products.index');
        }


    }



    public function edit($product, Request $request){

        $product = Product::find($product);
        if(empty($product)){
            $request->session()->flash('error', 'Product Not found.');
            return redirect()->route('products.index');
        }
        $authors = Author::where('status', 'active')->orderBy('name', 'asc')->get();
        //Fetch Product Image
        $productImages = ProductImage::where('product_id', $product->id)->get();

        $categories = Category::orderBy('name', 'asc')->get();
        $subCategories = SubCategory::where('category_id', $product->category_id)->orderBy('name', 'asc')->get();

        // Fetch Related Products
        $relatedProducts=[];
        if($product->related_products !=''){
           $productArray = explode(',',$product->related_products);
           $relatedProducts = Product::whereIn('id',$productArray)->get();
        }
        $bookTypes = BookType::orderBy('name', 'asc')->get();


        return view('admin.products.edit',compact('product','categories','subCategories','productImages','relatedProducts','authors','bookTypes') );
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$id,
            'compare_price' => 'nullable',
            'author_id' => 'required',
            'isbn_number' => 'nullable',
            'publisher_name' => 'nullable',
            'published_year' => 'nullable',
            'edition' => 'nullable',
            'country' => 'nullable',
            'language' => 'nullable',
            'pages' => 'nullable',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,'.$id,
            'track_qty' => 'required|in:Yes,No',
            'qty' => $request->filled('track_qty') ? 'required|numeric' : '',
            'category_id' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'description' => 'nullable',
            'barcode' => 'nullable',
            'book_type_id' => 'required',
            'status' => 'required|in:0,1',
            'sub_category_id' => 'nullable|numeric',
            'short_description' => 'nullable',
            'shipping_returns' => 'nullable',
            'related_products' => 'nullable',
            'ebook_price' => 'nullable|numeric',
            'ebook_compare_price' => 'nullable|numeric',
            'ebook' => 'nullable|file|mimes:pdf,epub|mimetypes:application/pdf,application/epub+zip|max:30048',



        ]);
        // Add conditional rules based on book_type_id
        $product = Product::findOrFail($id);
        if(!$product){
            if (in_array($request->book_type_id, [1, 3])) {
                $validator->sometimes('ebook_price', 'required|numeric', function ($input) {
                    return in_array($input->book_type_id, [1, 3]);
                });

                $validator->sometimes('ebook_compare_price', 'required|numeric', function ($input) {
                    return in_array($input->book_type_id, [1, 3]);
                });

                $validator->sometimes('ebook', 'required|file|mimes:pdf,epub|mimetypes:application/pdf,application/epub+zip|max:30048', function ($input) {
                    return in_array($input->book_type_id, [1, 3]);
                });
            }
        }


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product->fill($validator->validated());
        $product->related_products=(!empty($request->related_products)) ? implode(',',$request->related_products) : '';
        $product->save();


        // Save product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Validate the image
                $imageValidator = Validator::make(['image' => $image], [
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust maximum file size as needed
                ]);

                if ($imageValidator->fails()) {
                    // Handle validation failure
                    return redirect()->back()->withErrors($imageValidator)->withInput();
                }

                // Generate a unique file name
                $newName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

                // Move the uploaded image to the storage directory
                $image->move(public_path('products'), $newName);

                // Create a new record in the product_images table
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = $newName;
                $productImage->save();
            }

        }
        if ($request->hasFile('ebook')) {
            $ebook = $request->file('ebook');
            $ebookName = uniqid() . '_' . time() . '.' . $ebook->getClientOriginalExtension();
            $directory = 'ebooks/' . $product->id;

            // Store the new eBook in the 'public' directory
            $ebook->move(public_path($directory), $ebookName);

            // Delete the old eBook file if it exists
            $oldEbook = Ebook::where('product_id', $product->id)->first();
            if ($oldEbook && file_exists(public_path($oldEbook->file_location))) {
                unlink(public_path($oldEbook->file_location));
            }

            // Update the file_location of the associated eBook or create a new one
            if ($oldEbook) {
                $oldEbook->update([
                    'file_location' => $directory . '/' . $ebookName
                ]);
            } else {
                $newEbook = new Ebook();
                $newEbook->product_id = $product->id;
                $newEbook->file_location = $directory . '/' . $ebookName;
                $newEbook->save();
            }
        }

        $request->session()->flash('success', 'Product updated successfully.');
        return redirect()->route('products.index');
    }

    public function deleteImage(Request $request)
    {
        $imageId = $request->input('image_id');
        $image = ProductImage::find($imageId);

        if ($image) {
            // Delete the image file from the public folder
            $imagePath = public_path('products/' . $image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the image record from the database
            $image->delete();
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
        }
    }
    public function deleteEbook(Request $request){
        $ebookd = $request->input('ebookId');
        $ebook = Ebook::findOrFail($ebookd);
        if ($ebook) {
            // Delete the ebook file from the public folder
            $ebookPath = public_path($ebook->file_location);
            if (file_exists($ebookPath)) {
                unlink($ebookPath);
            }
            // Delete the ebook record from the database
            $ebook->delete();
            return response()->json(['success' => true, 'message' => 'Ebook deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Ebook not found.'], 404);
        }

    }
    public function destroy($id, Request $request)
    {
        $product = Product::find($id);

        if (empty($product)) {
            $request->session()->flash('error', 'Product not found.');
            return redirect()->route('products.index');
        }

        // Delete associated product images
        $productImages = ProductImage::where('product_id', $id)->get();
        if (!$productImages->isEmpty()) {
            foreach ($productImages as $productImage) {
                $imagePath = public_path('products/' . $productImage->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $productImage->delete();
            }
        }



        // Delete associated ebook file and product folder
        $productEbook = Ebook::where('product_id', $id)->first();
        if ($productEbook) {
            $ebookPath = public_path($productEbook->file_location);
            if (file_exists($ebookPath)) {
                unlink($ebookPath);
            }
            // Extracting the directory name from file path
            $directory = pathinfo($ebookPath, PATHINFO_DIRNAME);
            // Deleting the product folder along with its contents
            if (is_dir($directory)) {
                $files = glob($directory . '/*');
                foreach ($files as $file) {
                    unlink($file);
                }
                rmdir($directory);
            }
            $productEbook->delete();
        }

        // Delete the product
        $product->delete();

        $request->session()->flash('success', 'Product deleted successfully.');
        return redirect()->route('products.index');
    }
    public function getProducts(Request $request){
        $tempProduct=[];
        if($request->term != ''){
            $products = Product::where('title', 'like', '%' . $request->term . '%')->get();
            if($products != null){
                foreach ($products as $product){
                    $tempProduct[] = array('id'=>$product->id,'text'=>$product->title);
                }
            }
        }
        return response()->json([
            'tags' => $tempProduct,
            'status' => true,
        ]);

    }
    public function productRatings(){
        $ratings = ProductRating::latest()->paginate(10);
        return view('admin.products.ratings',compact('ratings') );
    }
    public function ratingSearch(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform the search query
        $ratings = ProductRating::where('username', 'like', '%' . $keyword . '%')
            ->orWhere('rating', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%')
            ->orWhere('comment', 'like', '%' . $keyword . '%')
            ->orWhereHas('product', function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->paginate(10);

        // Pass the search results to your view
        return view('admin.products.ratings', ['ratings' => $ratings]);
    }
    public function changeRatingStatus(Request $request){
        $rating = ProductRating::find($request->id);
        if($rating){
            $rating->status = $request->status;
            $rating->save();
            return response()->json(['status' => true, 'message' => 'Rating status updated successfully.']);
        }else{
            return response()->json(['status' => false, 'message' => 'Rating not found.'], 404);
        }

    }


}
