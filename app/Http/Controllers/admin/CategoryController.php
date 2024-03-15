<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::latest()->paginate(10);
        return view('admin.category.list',compact('categories'));

    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform the search query
        $categories = Category::where('name', 'like', '%' . $keyword . '%')->paginate(10);

        // Pass the search results to your view
        return view('admin.category.list', ['categories' => $categories]);
    }

    public function create(){
return view('admin.category.create');


    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required|unique:categories',
        ]);
        if($validator->passes()){
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();
            $request->session()->flash('success','Category Created Successfully');
            return response()->json([
                'status'=>true,
                'message'=>'Category Created Successfully'
            ]);

        }else{
            return response()->json([
                'status'=>false,
                'error'=>$validator->errors()
            ]);
        }

    }

    public function edit($id){

    }
    public function update(){

    }
    public function destory(){

    }
}
