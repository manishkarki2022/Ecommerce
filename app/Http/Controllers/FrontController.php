<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use App\Models\Author;
use App\Models\Highlight;
use App\Models\Page;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class FrontController extends Controller
{
    public function index(){
        $latest=  Product::latest()
            ->where('status',1)
            ->take(6)
            ->get();
       $getFeatured=  Product::where('is_featured','Yes')->get();
       $highlights = Highlight::where('is_active',1)->get();
       return view('front.home',compact('getFeatured','latest','highlights'));
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
    public function sendContactEmail(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);
        if ($validate) {
            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'mail_subject' => 'Contact Email'
            ];
            $admin = env('MAIL_FROM_ADDRESS');
            Mail::to($admin)->send(new ContactEmail($mailData));
            return redirect()->back()->with('success', 'Email sent successfully');
        } else {
            return redirect()->back()->with('error', 'Please fill all fields');
        }
    }

    public function authorIndex(){
        $authors = Author::where('status','active')->get();
        return view('front.author.index',compact('authors'));
    }
    public function authorShow($id){
        $author = Author::findOrFail($id);
        if(!$author){
            abort(404);
        }
        $relatedProducts = Product::where('author_id',$id)->get();
        return view('front.author.show',compact('author','relatedProducts'));

    }

}






