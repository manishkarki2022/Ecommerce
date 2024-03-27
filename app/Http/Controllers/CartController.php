<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipping;
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
            $user_info = CustomerAddress::where('user_id',Auth::id())->first();


            $cities = City::orderBy('name','asc')->get();

            //Calculate shipping charges
            if($user_info){

            $userCity = $user_info->city_id;

            $shippingInfo = Shipping::where('city_id', $userCity)->first();
            if($shippingInfo == null){
                $shippingInfo = Shipping::where('city_id','rest_of_city')->first();
            }
            $totalQty = 0;
            $totalShippingCharge = 0;
            $grandTotal = 0;

            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }
            $totalShippingCharge = $totalQty * $shippingInfo->amount;
            $grandTotal = Cart::subtotal(2, '.', '') + $totalShippingCharge;
        }else{
            $totalShippingCharge = 0;
            $grandTotal = Cart::subtotal(2, '.', '');
        }
        return view('front.checkout', compact('cities', 'user_info', 'totalShippingCharge', 'grandTotal'));

    }
    public function processCheckout(Request $request){

        $validator= $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'mobile'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip'=>'required',
            'state'=>'required',

        ]);
        if($validator){
            CustomerAddress::updateOrCreate(

                ['user_id'=>Auth::id()],
                [
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'email'=>$request->email,
                    'mobile'=>$request->mobile,
                    'city_id'=>$request->city_id,
                    'address'=>$request->address,
                    'zip'=>$request->zip,
                    'state'=>$request->state,
                    'user_id'=>Auth::id(),
                ]
            );
            //If payment method is cod then create order
            if($request->payment_method == 'cod'){
                // calculate shipping charges
                $subTotal = Cart::subtotal(2,'.','');
                $shipping = 0;
                $discount = 0;


                $shippingInfo = Shipping::where('city_id',$request->city_id)->first();
                $totalQty = 0;
                foreach (Cart::content() as $item){
                    $totalQty += $item->qty;
                }
                if($shippingInfo != null){
                    $shipping = $totalQty * $shippingInfo->amount;
                    $grandTotal = $subTotal + $shipping;

                }else{
                    $shippingInfo = Shipping::where('city_id','rest_of_city')->first();
                    $shipping = $totalQty * $shippingInfo->amount;
                    $grandTotal = $subTotal + $shipping;
                }


                $oder= new Order();
                $oder->user_id = Auth::id();
                $oder->coupon_code = null;
                $oder->shipping = $shipping;
                $oder->subtotal = $subTotal;
                $oder->discount = $discount;
                $oder->grand_total = $grandTotal;
                $oder->first_name = $request->first_name;
                $oder->last_name = $request->last_name;
                $oder->email = $request->email;
                $oder->mobile = $request->mobile;
                $oder->city_id = $request->city_id;
                $oder->address = $request->address;
                $oder->zip = $request->zip;
                $oder->state = $request->state;
                $oder->notes = $request->notes;
                $oder->save();

                //Save order items
                foreach (Cart::content() as $item){
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $oder->id;
                    $orderItem->product_id = $item->id;
                    $orderItem->name = $item->name;
                    $orderItem->qty = $item->qty;
                    $orderItem->price = $item->price;
                    $orderItem->total = $item->price * $item->qty;
                    $orderItem->save();
                }
                $type = 'success';
                $message = 'Order placed successfully';
                Cart::destroy();
                session()->flash($type, $message);
                $order = $oder->id;
                return redirect()->route('front.thanks', ['orderId' => $order]);



            }else{
            }

        }
    }
    public function thankYou($orderId){
        return view('front.thanks', compact('orderId'));
    }

    public function getOrderSummary(Request $request){
        $subTotal = Cart::subtotal(2,'.','');
        if($request->city_id>0){

            $shippingInfo = Shipping::where('city_id',$request->city_id)->first();
            $totalQty = 0;
            foreach (Cart::content() as $item){
                $totalQty += $item->qty;
            }

            if($shippingInfo != null){
                $shippingCharge = $shippingInfo->amount;
                $grandTotal = $subTotal + $shippingCharge;
                return response()->json([
                    'status'=>true,
                    'shippingCharge'=>number_format($shippingCharge,2),
                    'grandTotal'=>number_format($grandTotal,2)
                ]);
            }else{
                $shippingInfo = Shipping::where('city_id','rest_of_city')->first();
                $shippingCharge = $shippingInfo->amount;
                $grandTotal = $subTotal + $shippingCharge;
                return response()->json([
                    'status'=>true,
                    'shippingCharge'=>number_format($shippingCharge,2),
                    'grandTotal'=>number_format($grandTotal,2)
                ]);

            }
        }else{
            return response()->json([
                'status'=>true,
                'shippingCharge'=>number_format(0,2),
                'grandTotal'=>number_format($subTotal,2)
            ]);
        }
    }

}
