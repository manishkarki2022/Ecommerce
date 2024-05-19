<?php

use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\Website;
use Illuminate\Support\Facades\Mail;

function websiteInfo()
{
    return Website::get();
}

function getCategories()
{
    return Category::orderBy('name', 'asc')
        ->where('showHome','Yes')
        ->where('status',1)
        ->get();
}
function getProductImage($id){
    return ProductImage::where('product_id',$id)->first();
}
function orderEmail($orderId,$userType="customer"){
 $order = Order::where('id',$orderId)->with('items')->first();
if($userType == 'customer'){
    $subject = "Thank you for your order";
    $email = $order->email;

}
else{
    $subject = "You have received an order";
    $email = env('ADMIN_EMAIL');
}
 $mailData=[
     'subject'=>$subject,
     'order'=>$order,
     'userType'=>$userType,


 ];
 Mail::to($email)->send(new OrderEmail($mailData));

}
function getwishlist ($product_id){
    if(auth()->check()){
        $wishlist = \App\Models\Wishlist::where('product_id',$product_id)->where('user_id',auth()->id())->first();
        if($wishlist){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}
function getPages(){
    return \App\Models\Page::where('status',1)->get();
}



?>
