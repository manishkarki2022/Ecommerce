<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerifyEmail;
use App\Mail\ResetPasswordEmail;
use App\Models\City;
use App\Models\CustomerAddress;
use App\Models\Ebook;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(){
        return view('front.account.login');

    }
    public function register(){
        return view('front.account.register');

    }
    public function postRegister(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable ',
            'password' => 'required|min:6',
            'cpassword' => 'required|same:password'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
        // Generate a unique token
        $token = Str::random(60);
        //Delete any existing tokens for this user
        DB::table('email_verifications')->where('email', $request->email)->delete();
        DB::table('email_verifications')->insert([
            'email' => $request->email,
            'token' => $token,
        ]);
        $user = User::where('email', $request->email)->first();
        $formData = [
            'token' => $token,
            'name' => $user,
            'mailSubject' => 'Verify Email Address',
        ];
        Mail::to($request->email)->send(new EmailVerifyEmail($formData));

        return redirect()->route('account.login')->with('success', 'We have send email verification link sent to your email.');

    }
   public function verifyEmail($token){
        //Find the token in the database
        $emailVerification = DB::table('email_verifications')->where('token', $token)->first();
        //Check if the token exists
        if(!$emailVerification){
            return redirect()->route('account.login')->with('error', 'Invalid token');
        }
        //Find the user by email
        $user = User::where('email', $emailVerification->email)->first();
        //Update the user's email_verified_at field
        $user->email_verified_at = now();
        $user->save();
        //Delete the email verification token
        DB::table('email_verifications')->where('token', $token)->delete();
        //Redirect to the login page with success message
        return redirect()->route('account.login')->with('success', 'Email verified successfully');
   }



    public function authenticate(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                // Check if the user's email is verified
                if (Auth::user()->email_verified_at) {
                    if (session()->has('url.intended')) {
                        $intendedUrl = session()->get('url.intended');
                        session()->forget('url.intended'); // Delete the intended URL from session
                        return redirect($intendedUrl);
                    }
                    session()->flash('success', 'User logged in successfully');
                    return redirect()->route('front.home');
                } else {
                    Auth::logout();
                    session()->flash('error', 'Your email address is not verified. Please verify your email before logging in.');
                    return redirect()->route('account.login')->withInput($request->only('email', 'remember'));
                }
            } else {
                session()->flash('error', 'Invalid email or password');
                return redirect()->route('account.login')->withInput($request->only('email', 'remember'));
            }
        } else {
            session()->flash('error', 'Invalid email or password');
            return redirect()->route('account.login')->withInput($request->only('email', 'remember'));
        }
    }

    public function profile(){
        $cities = City::orderBy('name')->get();
        $customerInfo = CustomerAddress::where('user_id', Auth::id())->first();
        $userinfo = Auth::user();
        return view('front.account.profile',compact('userinfo','cities','customerInfo'));

    }
    public function updateProfile(Request $request){
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
            'phone' => 'nullable ',
        ]);
        if($validate){
            $user = User::find(Auth::id());
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();
            session()->flash('success', 'User updated successfully');
            return redirect()->route('account.profile');
        }
        else{
            return redirect()->back()->withInput($request->all());
        }

    }
    public function updateAddress(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'nullable',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required',
            'zip' => 'required',
            'state' => 'required',
        ]);

        // Create or update user's address information
        $customerAddress = CustomerAddress::updateOrCreate(
            ['user_id' => Auth::id()],
            $validatedData
        );

        if ($customerAddress) {
            session()->flash('success', 'Address updated successfully');
            return redirect()->route('account.profile');
        } else {
            session()->flash('error', 'Failed to update address');
            return redirect()->back()->withErrors(['Failed to update address']);
        }
    }




    public function logout(){
        Auth::logout();
        session()->flash('success', 'User logged out successfully');
        return redirect()->route('account.login');

    }
    public function orders(){
        $user = Auth::user();
         $orders = Order::where('user_id', $user->id)->latest()->paginate(5);
        return view ('front.account.order',compact('orders'));
    }
    public function orderDetail($id){
        $order = Order::where('user_id', Auth::id())->where('id', $id)->first();
        $orderItems = OrderItem::where('order_id', $id)->get();
        return view('front.account.order-detail',compact('order', 'orderItems'));

    }
    public function wishlist(){
        $wishlists = Wishlist::where('user_id', Auth::id())->get();
        return view('front.account.wishlist',compact('wishlists'));

    }
    public function deleteWishlist(Request $request, $id)
    {

        if (!Auth::check()) {
            session()->flash('error', 'Please login to delete wishlist items.');
            return redirect()->route('account.login');
        }

        // Find the wishlist item
        $wishlistItem = Wishlist::where('user_id', Auth::id())->where('product_id', $id)->first();

        // Check if the wishlist item exists
        if ($wishlistItem) {
            // Delete the wishlist item
            $wishlistItem->delete();
            return redirect()->back()->with('success', 'Product removed from wishlist successfully.');
        } else {
            return redirect()->back()->with('error', 'Product not found in wishlist.');
        }
    }
    public function changePassword(){
        return view('front.account.change-password');
    }
    public function updatePassword(Request $request)
    {
        // Validate form data
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|different:old_password', // Ensure new password is different from old password
            'confirm_password' => 'required|same:new_password', // Confirm password should match new password
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the old password matches the user's current password
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'The old password is incorrect.');
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect back with success message
        return redirect()->route('account.changePassword')->with('success', 'Password changed successfully.');
    }
    public function forgotPassword(){
        return view('front.account.forgot-password');
    }
    public function processForgotPassword(Request $request)
    {
        // Validate form data
        $validate = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        if($validate == false){
            return redirect()->back()->with('error', 'Email not found');
        }


           // Generate a unique token
        $token = Str::random(60);
        //Delete any existing tokens for this user
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);
        $user = User::where('email', $request->email)->first();
        $formData = [
            'token' => $token,
            'name' => $user,
            'mailSubject' => 'Reset Password Email',
        ];
        Mail::to($request->email)->send(new ResetPasswordEmail($formData));
        return redirect()->back()->with('success', 'Password reset link sent to your email.');
    }
    public function resetPassword($token)
    {
        // Find the token in the database
        $passwordResetToken = DB::table('password_reset_tokens')->where('token', $token)->first();

        // Check if the token exists
        if (!$passwordResetToken) {
            return redirect()->route('front.forgotPassword')->with('error', 'Invalid token.');
        }

        // Check if the token is expired
        if (now() > Carbon::parse($passwordResetToken->created_at)->addMinutes(10)) {
            return redirect()->route('front.forgotPassword')->with('error', 'Token expired.');
        }
        //delete the token
        DB::table('password_reset_tokens')->where('token', $token)->delete();

        // Render the reset password form
        return view('front.account.reset-password',compact('token'));
    }
public function processResetPassword(Request $request)
    {
        // Validate form data
        $request->validate([
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|same:new_password',
            'reset_token' => 'required',
        ]);

        // Find the token in the database
        $passwordResetToken = DB::table('password_reset_tokens')->where('token', $request->reset_token)->first();

        // Check if the token exists
        if (!$passwordResetToken) {
            return redirect()->route('front.forgotPassword')->with('error', 'Invalid token.');
        }

        // Check if the token is expired
        if (now() > Carbon::parse($passwordResetToken->created_at)->addMinutes(10)) {
            return redirect()->route('front.forgotPassword')->with('error', 'Token expired.');
        }

        // Find the user by email
        $user = User::where('email', $passwordResetToken->email)->first();

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Delete the password reset token
        DB::table('password_reset_tokens')->where('token', $request->token)->delete();

        // Redirect to the login page with success message
        return redirect()->route('account.login')->with('success', 'Password reset successfully.');
    }
    public function myBooks(){
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->where('payment_status', 'paid')
            ->where('book','ebook')
            ->latest()->paginate(5);
        return view('front.account.mybook',compact('orders'));
    }
    public function myBookShow($product_id)
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        $ebook = Ebook::where('product_id', $product_id)->first();

        // Check if the ebook file exists
        if (!$ebook || !file_exists(public_path($ebook->file_location))) {
            abort(404);
        }

        // Get the URL of the EPUB file
        $fileUrl = asset($ebook->file_location);

        // Pass the file URL to the view
        return view('front.account.ebookshow', compact('fileUrl'));
    }

}
