<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
public function index(){
    $latest=  Product::latest()
        ->where('status',1)
        ->take(6)
        ->get();
   $getFeatured=  Product::where('is_featured','Yes')->get();
   return view('front.home',compact('getFeatured','latest'));
    }
    public function addWishlist(Request $request){

        if(Auth::check()==false){
        session()->put('url.intended',url()->previous());
        return response()->json([
            'status'=>false,
            'message'=>'Please login to add wishlist']);
        }
        $exists = Wishlist::where('user_id',Auth::id())
            ->where('product_id',$request->id)
            ->exists();
        if($exists){
            return response()->json([
                'status'=>'error',
                'message'=>'Product already in wishlist']);
        }
        $wishlist = new Wishlist();
        $wishlist->user_id = Auth::id();
        $wishlist->product_id = $request->id;
        $wishlist->save();
        return response()->json([
            'status'=>true,
            'message'=>'Product added to wishlist']);
}

    public function page($slug){
        $page = Page::where('slug', $slug)->first();
        if (!$page) {
            // If page not found, render the 404 error view without passing the $page variable
            abort(404);
        }
        return view('front.page',compact('page'));
    }



}
