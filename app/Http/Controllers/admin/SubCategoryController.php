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
        $subCategory->showHome = $request->showHome;
        $subCategory->save();
        $request->session()->flash('success','Sub Category Created Successfully');
        return redirect()->route('sub-categories.index');
    }
    public function edit($subCategory){
        $subCategory = SubCategory::find($subCategory);
        $categories = Category::orderBy('name')->get(); // No need for 'asc', it's the default
        if(empty($subCategory)){
            return redirect()->route('sub-categories.index');
        }
        return view('admin.sub-category.edit', compact('subCategory', 'categories'));
    }
    public function update($id, Request $request) {
        $subCategory = SubCategory::find($id);

        if (!$subCategory) {
            $request->session()->flash('error', 'Sub Category Not Found');
            return redirect()->route('sub-categories.index');
        }

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subCategory->id,
            'status' => 'required',
            'category_id' => 'required',
        ]);

        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->status = $request->status;
        $subCategory->showHome = $request->showHome;

        $subCategory->category_id = $request->category_id; // Make sure field name matches with the form
        $subCategory->save();

        $request->session()->flash('success', 'Sub Category Updated Successfully');
        return redirect()->route('sub-categories.index');
    }
    public function destroy($id, Request $request) {
        $subCategory = SubCategory::find($id);

        if (!$subCategory) {
            $request->session()->flash('error', 'Sub Category Not Found');
            return redirect()->route('sub-categories.index');
        }

        $subCategory->delete();

        $request->session()->flash('success', 'Sub Category Deleted Successfully');
        return redirect()->route('sub-categories.index');
    }
}
