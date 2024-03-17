<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(){
        $subCategories = SubCategory::latest('id')->paginate(10);
        return view('admin.sub-category.index',compact('subCategories'));
    }

    public function search(Request $request)
    {
        // Get the keyword from the request
        $keyword = $request->input('keyword');

        // Perform the search query
        $subCategories = SubCategory::where('name', 'like', '%' . $keyword . '%')
            ->orWhereHas('category', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->paginate(10);

        // Pass the search results to your view
        return view('admin.sub-category.index', compact('subCategories'));
    }



    public function create(){
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.sub-category.create',compact('categories'));
    }
    public function store(Request $request){
//        dd($request->all());
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'status' => 'required',
            'category' => 'required',
        ]);
        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->status = $request->status;
        $subCategory->category_id = $request->category;
        $subCategory->save();
        $request->session()->flash('success','Sub Category Created Successfully');
        return redirect()->route('sub-categories.index');


    }
}
