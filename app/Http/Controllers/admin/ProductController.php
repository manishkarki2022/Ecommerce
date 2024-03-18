<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.create',compact('categories') );

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'compare_price' => 'nullable',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'qty' => $request->filled('track_qty') ? 'required|numeric' : '',
            'category_id' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'description' => 'nullable',
            'barcode' => 'nullable',
            'status' => 'required|in:0,1',
            'sub_category_id' => 'nullable|numeric'


        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = new Product($validator->validated());;
        $product->save();

        //Save product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Validate the image
                $validator = Validator::make(['image' => $image], [
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust maximum file size as needed
                ]);

                if ($validator->fails()) {
                    // Handle validation failure
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Generate a unique file name
                $newName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

                // Move the uploaded image to the storage directory
                $image->move(public_path('products'), $newName);

                // Create a new record in the product_images table
                $product->images()->create(['image' => $newName]);
            }
        }

        $request->session()->flash('success', 'Product created successfully.');
        return redirect()->route('products.index');
    }



    public function edit($product, Request $request){

        $product = Product::find($product);
        if(empty($product)){
            $request->session()->flash('error', 'Product Not found.');
            return redirect()->route('products.index');
        }
        //Fetch Product Image
        $productImages = ProductImage::where('product_id', $product->id)->get();

        $categories = Category::orderBy('name', 'asc')->get();
        $subCategories = SubCategory::where('category_id', $product->category_id)->orderBy('name', 'asc')->get();
        return view('admin.products.edit',compact('product','categories','subCategories','productImages') );
    }
    public function update(Request $request, $productId)
    {
        $product = Product::find($productId);
        if (empty($product)) {
            $request->session()->flash('error', 'Product not found.');
            return redirect()->route('products.index');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id,
            'compare_price' => 'nullable',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'track_qty' => 'required|in:Yes,No',
            'qty' => $request->filled('track_qty') ? 'required|numeric' : '',
            'category_id' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'description' => 'nullable',
            'barcode' => 'nullable',
            'status' => 'required|in:0,1',
            'sub_category_id' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product->update($validator->validated());

        // Handle image uploads
        if ($request->hasFile('images')) {
//            dd('here');
            foreach ($request->file('images') as $image) {
                // Validate the image
                $validator = Validator::make(['image' => $image], [
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust maximum file size as needed
                ]);

                if ($validator->fails()) {
                    // Handle validation failure
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Generate a unique file name
                $newName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

                // Move the uploaded image to the storage directory
                $image->move(public_path('products'), $newName);

                // Delete existing product images
                $product->images()->delete();

                // Create a new record in the product_images table
                $product->images()->create(['image' => $newName]);
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
    public function destroy($id,Request $request){
        $product = Product::find($id);
        if(empty($product)){
            $request->session()->flash('error', 'Product Not found.');
            return redirect()->route('products.index');
        }
        $productImages = ProductImage::where('product_id', $id)->get();
        if(!$productImages->isEmpty()){
            foreach ($productImages as $productImage){
                $imagePath = public_path('products/' . $productImage->image);
            }
            ProductImage::where('product_id', $id)->delete();
        }
        $product->delete();
        $request->session()->flash('success', 'Product deleted successfully.');
        return redirect()->route('products.index');

    }


}
