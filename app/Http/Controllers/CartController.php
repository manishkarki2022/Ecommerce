<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

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
    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);
        //check qty is available in stock
        $product = Product::find($itemInfo->id);
        if($product->track_qty == "Yes"){
            if($product->qty >= $qty){
                Cart::update($rowId, $qty);
                $message = 'Cart updated successfully';
                $status = true;
                $type = 'success';
            }else{
                $message = 'Request qty ('.$qty.') not available in stock';
                $status = false;
                $type = 'error';

            }
        }else{
            Cart::update($rowId, $qty);
            $status = true;
            $message = 'Cart updated successfully';
            $type = 'success';

        }
        session()->flash($type, $message);
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);


    }
    public function deleteItem(Request $request){
        $itemInfo = Cart::get($request->rowId);
        if($itemInfo){
            $productName = $itemInfo->name;
            Cart::remove($request->rowId);
            $status = true;
            $type='success';
            $message = $productName.' removed from cart';
        }else{
            $status = false;
            $type='error';
            $message = 'Item not found in cart';
        }
        session()->flash($type, $message);
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);

    }
    public function checkout(){
        //If cart is empty redirect to cart page
        if(Cart::count()==0){
            return redirect()->route('front.cart');
        }
        //IF user is not logged in then redirect to login page
        if(!Auth::check()){
            if(!session()->has('url.intended')){
                session(['url.intended' => url()->current()]);
            }

            return redirect()->route('account.login');

        }
            $cities = City::orderBy('name','asc')->get();
            return view('front.checkout',compact('cities'));

    }

}
