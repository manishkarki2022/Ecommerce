<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

}
