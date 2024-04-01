<?php

use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Mail;

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
function orderEmail($orderId){
 $order = Order::where('id',$orderId)->with('items')->first();
 $mailData=[
     'subject'=>'Thank you for your order',
        'order'=>$order
 ];
 Mail::to($order->email)->send(new OrderEmail($mailData));

}



?>
