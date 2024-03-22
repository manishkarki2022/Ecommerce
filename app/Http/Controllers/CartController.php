<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $status = false;
        $message = '';
        $request->validate([
            'id'=>'required|numeric'
        ]);
        $product = Product::with('images')->find($request->id);
        if($product == null){
            return response()->json([
                'status'=>false,
                'message'=>'Product not found'
            ]);
        }
        if(Cart::count() > 0){
//            echo "Product already in cart";
            $cartContent = Cart::content();
            $productAlreadyExist = false;
            foreach ($cartContent as $item){
                if($item->id == $product->id){
                    $productAlreadyExist = true;

                }
            }
            if($productAlreadyExist==false){
                Cart::add($product->id, $product->title, 1, $product->price, ['images' => (!empty($product->images) ? $product->images->first() : '')]);
                $status = true;
                $message = $product->title." added to cart";
            }else{
                $status = false;
                $message = $product->title." already in cart";
            }



        }else{
            Cart::add($product->id, $product->title, 1, $product->price, ['images' => (!empty($product->images) ? $product->images->first() : '')]);
            $status = true;
            $message = $product->title." added to cart";
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
    public function cart() {
        $cartItems = Cart::content();
        return view('front.cart', ['cartItems' => $cartItems]);
    }

}
