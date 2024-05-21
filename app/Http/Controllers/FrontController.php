<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Highlight;
use App\Models\Page;
use App\Models\Product;
use App\Models\Wishlist;
use Artesaos\SEOTools\Facades\SEOTools as SEO;
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
       $blogs = Blog::where('status','active')->take(8)->get();
        SEO::setTitle(websiteInfo()->first()->name);
        SEO::setDescription(giveSmoothText(websiteInfo()->first()->description, 320));;
        SEO::opengraph()->setUrl(route('front.home'));
        SEO::opengraph()->addProperty('type', 'website');
        SEO::twitter()->setSite('@LuizVinicius73');//
       return view('front.home',compact('getFeatured','latest','highlights','blogs'));
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
        // Set SEO metadata for the page show page
        // Set SEO metadata for the page show page
        SEO::setTitle($page->name . ' - Page'); // Update with the Page's name
        SEO::setDescription(giveSmoothText($page->contents, 320)); // Update with a relevant description
        SEO::metatags()->addMeta('keywords', $page->name . ', page, content'); // Add relevant keywords
        SEO::opengraph()->setUrl(route('front.page', $page->slug)); // Set canonical URL
        SEO::opengraph()->addProperty('type', 'article'); // Set OpenGraph type as article
        SEO::opengraph()->addProperty('updated_time', date('c', strtotime($page->updated_at))); // Add updated time
        SEO::opengraph()->addProperty('image:width', '960'); // Add image width
        SEO::opengraph()->addProperty('image:height', '520'); // Add image height
        SEO::twitter()->setSite('@YourTwitterHandle'); // Set Twitter handle
        SEO::jsonLd()->setTitle($page->name . ' - Page'); // Add JSON-LD metadata
        SEO::jsonLd()->setDescription(giveSmoothText($page->contents, 320)); // Add JSON-LD metadata
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
        // Set SEO metadata for the author index page
        SEO::setTitle('Authors'); //
        SEO::setDescription('Explore our collection of talented authors.'); // Update with a relevant description
        SEO::metatags()->addMeta('keywords', 'authors, writers, literature'); // Add relevant keywords
        SEO::opengraph()->setUrl(route('front.author')); // Set canonical URL
        SEO::opengraph()->addProperty('type', 'website'); // Set OpenGraph type
        SEO::twitter()->setSite('@LuizVinicius73'); // Set Twitter handle
        return view('front.author.index',compact('authors'));
    }
    public function authorShow($slug){
        $author = Author::where('slug', $slug)->firstOrFail();
        if(!$author){
            abort(404);
        }
        $authorImage = asset('authorImage/' . $author->id . '/' . $author->authorImage->first()->image);
        $relatedProducts = Product::where('author_id',$slug)->get();
        // Set SEO metadata for the author show page
        SEO::setTitle($author->name . ' - Author Profile'); // Update with the author's name
        SEO::setDescription(giveSmoothText($author->description, 320));;
        SEO::metatags()->addMeta('keywords', $author->name . ', author, writer, literature'); // Add relevant keywords
        SEO::opengraph()->setUrl(route('front.author.show', $author->slug)); // Set canonical URL
        SEO::opengraph()->addProperty('type', 'profile'); // Set OpenGraph type as profile
        SEO::opengraph()->addProperty('updated_time', date('c', strtotime($author->updated_at)));
        SEO::opengraph()->addImage($authorImage);
        SEO::opengraph()->addProperty('image:width', '960');
        SEO::opengraph()->addProperty('image:height', '520');
        SEO::twitter()->setSite('@LuizVinicius73'); // Set Twitter handle
        SEO::jsonLd()->setTitle($author->name . ' - Author Profile'); // Add JSON-LD metadata
        SEO::twitter()->setImage($authorImage);
        SEO::jsonLd()->setDescription(giveSmoothText($author->description, 320)); // Add JSON-LD metadata
        SEO::jsonLd()->addImage($authorImage); // Add JSON-LD metadata
        return view('front.author.show',compact('author','relatedProducts'));

    }
    public function blogIndex(){
        $blogs = Blog::where('status','active')->paginate(12);
        // Set SEO metadata for the blog index page
        SEO::setTitle('Blog'); // Update with a relevant title for your blog index page
        SEO::setDescription('Explore our latest blog posts for insightful content.'); // Update with a relevant description
        SEO::metatags()->addMeta('keywords', 'blog, articles, posts, news'); // Add relevant keywords
        SEO::opengraph()->setUrl(route('front.blog')); // Set canonical URL
        SEO::opengraph()->addProperty('type', 'website'); // Set OpenGraph type
//        SEO::opengraph()->addImage('/path/to/your/image.jpg'); // Add an image URL for OpenGraph
        SEO::twitter()->setSite('@LuizVinicius73'); // Set Twitter handle
//        SEO::twitter()->setImage('/path/to/your/image.jpg'); // Add an image URL for Twitter card
        SEO::jsonLd()->setTitle('Blog'); // Add JSON-LD metadata
        SEO::jsonLd()->setDescription('Explore our latest blog posts for insightful content.'); // Add JSON-LD metadata
        SEO::jsonLd()->setType('Blog'); // Add JSON-LD metadata
//        SEO::jsonLd()->addImage('/path/to/your/image.jpg'); // Add JSON-LD metadata
        return view('front.blog.index',compact('blogs'));
    }
    public function blogShow($slug) {
        $blog = Blog::where('slug', $slug)->first();

        if (!$blog) {
            return redirect()->back()->with('error', 'Blog not found.');
        }
        $blogImage = asset('blogs/' . $blog->image);
        // Set SEO metadata for the blog show page
        SEO::setTitle($blog->name . ' - Blog'); // Update with the blog's name
        SEO::setDescription($blog->excerpt);;
        SEO::metatags()->addMeta('keywords', $blog->name . ', author, writer, literature'); // Add relevant keywords
        SEO::opengraph()->setUrl(route('front.blog.show', $blog->slug)); // Set canonical URL
        SEO::opengraph()->addProperty('type', 'profile'); // Set OpenGraph type as profile
        SEO::opengraph()->addProperty('updated_time', date('c', strtotime($blog->updated_at)));
        SEO::opengraph()->addImage($blogImage);
        SEO::opengraph()->addProperty('image:width', '960');
        SEO::opengraph()->addProperty('image:height', '520');
        SEO::twitter()->setSite('@LuizVinicius73'); // Set Twitter handle
        SEO::jsonLd()->setTitle($blog->name . ' - Author Profile'); // Add JSON-LD metadata
        SEO::twitter()->setImage($blogImage);
        SEO::jsonLd()->setDescription($blog->excerpt);; // Add JSON-LD metadata
        SEO::jsonLd()->addImage($blogImage); // Add JSON-LD metadata



        return view('front.blog.show', compact('blog'));
    }
    public function blogLike(Request $request,Blog $blog){
        if ($request->ajax()) {
            // Assuming you have a method to handle the like logic
            $blog->likes_count += 1; // Increment the like count for demonstration
            $blog->save();

            return response()->json([
                'success' => true,
                'likes_count' => $blog->likes_count,
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    public function blogComment(Request $request, Blog $blog){
        {
            $request->validate([
                'content' => 'required|max:255',
            ]);
            $comment = new Comment();
            $comment->content = $request->input('content'); // Using input() method
            $comment->blog_id = $blog->id;
            $comment->user_id = auth()->id(); // Assuming users are authenticated
            $comment->save();

            return redirect()->back()->with('success', 'Comment added successfully');
        }

    }

}






