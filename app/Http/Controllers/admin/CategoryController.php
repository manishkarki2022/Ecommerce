<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Intervention\Image\Laravel\Facades\Image;


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
            //Save Image
//            if(!empty($request->image_id)){
//                $tempImage = TempImage::find($request->image_id);
//                $extArray=  explode('.',$tempImage->name);
//                $ext = last($extArray);
//
//                $newImageName =$category->id.'.'.$ext;
//                $sPath = public_path().'/temp/'.$tempImage->name;
//                $dPath = public_path().'/uploads/category'.$newImageName;
//                File::copy($sPath,$dPath);
//
//                // Generate Thumbnail
//                $dPath = public_path().'/uploads/category/thump/'.$newImageName; // Corrected the directory path
//                $img = Image::read($dPath); // Using the Image facade
//                $img->resize(450, 600);
//                $img->save($dPath);
//
//
//                $category->image = $newImageName;
//                $category->save();
//
//            }





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

    public function edit($category){
        $category = Category::find($category);
        if(empty($category)){
            return redirect()->route('categories.index');
        }
        return view('admin.category.edit',compact('category'));

    }
    public function update($categoryID,Request $request)
    {
        $category = Category::find($categoryID);
        if(empty($category)){
            $request->session()->flash('error','Category Not Found');
            return redirect()->route('categories.index');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $categoryID.',id',
        ]);
        if ($validator->passes()) {
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();
        }
        $request->session()->flash('success','Category Updated Successfully');
        return response()->json([
            'status'=>true,
            'message'=>'Category Update Successfully'
        ]);
    }
    public function destroy($id,Request $request){
        $category = Category::find($id);
        if(empty($category)){
            $request->session()->flash('error','Category Not Found');
            return redirect()->route('categories.index');
        }
        $category->delete();
        $request->session()->flash('success','Category Deleted Successfully');
        return redirect()->route('categories.index');
    }
}
