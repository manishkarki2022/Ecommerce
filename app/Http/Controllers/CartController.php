<?php

namespace App\Http\Controllers;
// Init composer autoloader.
require '../vendor/autoload.php';

use RemoteMerge\Esewa\Client;
use RemoteMerge\Esewa\Config;

use App\Models\City;
use App\Models\CouponCode;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $status = false;
        $message = '';

        $request->validate([
            'id' => 'required|numeric',
            'type' => 'required|in:ebook,paperback', // Validate the type parameter
        ]);

        $product = Product::with('images')->find($request->id);

        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        $cartContent = Cart::content();
        $ebookExist = false;
        $printedBookExist = false;

        foreach ($cartContent as $item) {
            if ($item->options['type'] == 'ebook' && $item->id == $product->id) {
                $ebookExist = true;
            } elseif ($item->options['type'] == 'paperback' && $item->id == $product->id    ) {
                $printedBookExist = true;
            }
        }

        // Add the product to the cart based on the type
        if ($request->type == 'ebook' && $product->ebook_price !== null && !$ebookExist) {
            Cart::add($product->id, $product->title, 1, $product->ebook_price, ['type' => 'ebook', 'images' => (!empty($product->images) ? $product->images->first() : '')]);
            $status = true;
            $message = $product->title . " (eBook) added to cart";
        } elseif ($request->type == 'paperback' && !$printedBookExist) {
            Cart::add($product->id, $product->title, 1, $product->price, ['type' => 'paperback', 'images' => (!empty($product->images) ? $product->images->first() : '')]);
            $status = true;
            $message = $product->title . " (Paperback book) added to cart";
        } else {
            $status = false;
            $message = "You can't add this book type to the cart as there's already a book of the same type";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
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
        $discount = 0;
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
            $subTotal =Cart::subtotal(2, '.', '');
        //Apply discount Here
        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percentage'){
                $discount = ($code->discount_amount/100)*$subTotal;
            }else{
                $discount = $code->discount_amount;

            }
        }

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
                    if($item->options->type != 'ebook'){
                        $totalQty += $item->qty;
                    }
                }
            $totalShippingCharge = $totalQty * $shippingInfo->amount;
            $grandTotal = ($subTotal-$discount) + $totalShippingCharge;
        }else{
            $totalShippingCharge = 0;
            $grandTotal = ($subTotal-$discount) ;
        }
        return view('front.checkout', compact('cities', 'user_info', 'totalShippingCharge', 'grandTotal','discount'));

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
        if($validator) {
            CustomerAddress::updateOrCreate(

                ['user_id' => Auth::id()],
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'city_id' => $request->city_id,
                    'address' => $request->address,
                    'zip' => $request->zip,
                    'state' => $request->state,
                    'user_id' => Auth::id(),
                ]
            );
            //If payment method is cod then create order
            if ($request->payment_method == 'esewa') {
                // calculate shipping charges
                $subTotal = Cart::subtotal(2, '.', '');
                $shipping = 0;
                $discount = 0;
                $discount_code = '';
                $discountCodeId = null;

                if (session()->has('code')) {
                    $code = session()->get('code');
                    if ($code->type == 'percentage') {
                        $discount = ($code->discount_amount / 100) * $subTotal;
                    } else {
                        $discount = $code->discount_amount;
                    }
                    $discountCodeId = $code->id;
                    $discount_code = $code->code;
                }


                $shippingInfo = Shipping::where('city_id', $request->city_id)->first();
                $totalQty = 0;
                foreach (Cart::content() as $item) {
                    if ($item->options->type != 'ebook') {
                        $totalQty += $item->qty;
                    }
                }
                if ($shippingInfo != null) {
                    $shipping = $totalQty * $shippingInfo->amount;
                    $grandTotal = ($subTotal - $discount) + $shipping;

                } else {
                    $shippingInfo = Shipping::where('city_id', 'rest_of_city')->first();
                    $shipping = $totalQty * $shippingInfo->amount;
                    $grandTotal = ($subTotal - $discount) + $shipping;
                }
                $oder = new Order();
                $oder->user_id = Auth::id();
                $oder->coupon_code = $discount_code;
                $oder->shipping = $shipping;
                $oder->subtotal = $subTotal;
                $oder->discount = $discount;
                $oder->payment_status = 'not paid';
                $oder->status = 'pending';
                $oder->coupon_code_id = $discountCodeId;
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
                foreach (Cart::content() as $item) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $oder->id;
                    $orderItem->product_id = $item->id;
                    $orderItem->name = $item->name;
                    $orderItem->qty = $item->qty;
                    $orderItem->price = $item->price;
                    $orderItem->total = $item->price * $item->qty;
                    $orderItem->save();

                    //Update product qty
                    $product = Product::find($item->id);
                    if ($product->track_qty == "Yes") {
                        $product->qty = $product->qty - $item->qty;
                        $product->save();
                    }
                }
                //Initiate Esewa Payment
                $successUrl = route('front.thanks');
                $failureUrl = route('front.checkout');

                // Config for development.
                $config = new Config($successUrl, $failureUrl);

//                // Config for production.
//                $config = new Config($successUrl, $failureUrl, 'b4e...e8c753...2c6e8b');

                // Initialize eSewa client.
                $esewa = new Client($config);

                $esewa->process($oder->id, $grandTotal, 0, 0, $shipping);


//                //Send Email to
//                orderEmail($oder->id,'customer');
//                $type = 'success';
//                $message = 'Order placed successfully';
//                Cart::destroy();
//                session()->forget('code');
//                session()->flash($type, $message);
//                $order = $oder->id;
//                return redirect()->route('front.thanks', ['orderId' => $order]);


            }
            //If payment method is cod then create order
            if ($request->payment_method == 'cod') {
                $oder = new Order();
                $oder->user_id = Auth::id();
                $oder->shipping = 0;
                $oder->discount = 0;
                $oder->subtotal = Cart::subtotal(2, '.', '');
                $oder->grand_total = $oder->subtotal + $oder->shipping - $oder->discount;
                $oder->coupon_code = null;


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
                foreach (Cart::content() as $item) {
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
                $orderId = $oder->id;
                // Pass the order ID to the view
                return view('front.thanks', compact('orderId'));

            }
        }
    }
    public function thankYou(Request $request){
        // Get the order ID from the request
        $orderId = $request->query('oid');

        // Find the order by its ID
        $order = Order::find($orderId);

        // Check if the order exists
        if($order == null){
            // If the order does not exist, redirect back to the cart page
            return redirect()->route('front.cart');
        }

        // Update the order status and payment status
        $order->payment_status = 'paid';
        $order->status = 'delivered';

        // If the order is for an ebook, update the 'book' field accordingly
        $order->book = 'ebook';

        // Save the changes to the order
        $order->save();

        // Clear the cart
        Cart::destroy();

        // Send email notification to the customer
        orderEmail($order->id, 'customer');

        // Flash a success message
        $type = 'success';
        $message = 'Order placed successfully';
        session()->flash($type, $message);

        // Pass the order ID to the view
        return view('front.thanks', compact('orderId'));
    }

    public function getOrderSummary(Request $request){
        $subTotal = Cart::subtotal(2,'.','');
        $discount = 0;
        $discountString = '';

        // Apply discount
        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percentage'){
                $discount = ($code->discount_amount/100)*$subTotal;
            } else {
                $discount = $code->discount_amount;
            }
            $discountString = '<div class="apply-coupan mt-4" id="discount-row">
                    <strong>' . session('code')->code . '</strong>
                    <a href="#" class="btn btn-sm btn-danger ml-2" id="remove-discount"><i class="fa fa-times"></i></a>
                </div>';
        }

        if($request->city_id > 0){
            $shippingInfo = Shipping::where('city_id', $request->city_id)->first();
            $totalQty = 0;
            foreach (Cart::content() as $item) {
                if($item->options->type != 'ebook'){
                    $totalQty += $item->qty;
                }
            }

            if($shippingInfo != null){
                $shippingCharge = $shippingInfo->amount;
                $shippingCharge = $totalQty * $shippingCharge;
                $grandTotal = ($subTotal - $discount) + $shippingCharge;
                return response()->json([
                    'status' => true,
                    'shippingCharge' => number_format($shippingCharge, 2),
                    'discount' => number_format($discount, 2),
                    'discountString' => $discountString,
                    'grandTotal' => number_format($grandTotal, 2)
                ]);
            } else {
                $shippingInfo = Shipping::where('city_id', 'rest_of_city')->first();
                $shippingCharge = $shippingInfo->amount;
                $shippingCharge = $totalQty * $shippingCharge;
                $grandTotal = ($subTotal - $discount) + $shippingCharge;
                return response()->json([
                    'status' => true,
                    'shippingCharge' => number_format($shippingCharge, 2),
                    'discount' => number_format($discount, 2),
                    'discountString' => $discountString,
                    'grandTotal' => number_format($grandTotal, 2)
                ]);
            }
        } else {
            return response()->json([
                'status' => true,
                'shippingCharge' => number_format(0, 2),
                'discount' => $discount,
                'discountString' => $discountString,
                'grandTotal' => number_format(($subTotal - $discount), 2)
            ]);
        }
    }
    public function applyDiscount(Request $request){
        $code = CouponCode::where('code',$request->code)->where('status','1')->first();
        if($code == null){
            return response()->json([
                'status'=>false,
                'message'=>'Invalid coupon code'
            ]);
        }
        //Check if coupon start date is valid or not
        $now = Carbon::now();
        if($code->starts_at !=""){
            $startDate = Carbon::create('Y-m-d H:i:s',$code->starts_at);

            if($now->lessThan($startDate)){
                return response()->json([
                    'status'=>false,
                    'message'=>'Coupon code is not valid yet'
                ]);
            }
        }
        if($code->expires_at !=""){
            $endDate = Carbon::create('Y-m-d H:i:s',$code->expires_at);

            if($now->greaterThan($endDate)){
                return response()->json([
                    'status'=>false,
                    'message'=>'Coupon code is not valid yet'
                ]);
            }
        }
        //Max uses Check
        if($code->max_uses> 0){
            $couponUsed = Order::where('coupon_code_id',$code->id)->count();
            if($couponUsed >= $code->max_uses){
                return response()->json([
                    'status'=>false,
                    'message'=>'Coupon code limit exceeded'
                ]);
            }
        }


        // Max uses user check
        if($code->max_uses_user > 0){
            $couponUsedByUser = Order::where(['coupon_code_id'=>$code->id,'user_id'=>Auth::user()->id])->count();
            if($couponUsedByUser >= $code->max_uses_user){
                return response()->json([
                    'status'=>false,
                    'message'=>'You already used this coupon code'
                ]);
            }
        }
        //Min amount condition check
        $subTotal =Cart::subtotal(2, '.', '');
        if($code->min_amount > 0){
            if($subTotal < $code->min_amount){
                return response()->json([
                    'status'=>false,
                    'message'=>'Minimum amount required to apply this coupon code '.$code->min_amount,
                ]);
            }
        }

        //








        session()->put('code',$code);
        return $this->getOrderSummary($request);
    }

    public function removeDiscount(Request $request){
        session()->forget('code');
        return $this->getOrderSummary($request);

    }

}
