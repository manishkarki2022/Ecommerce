<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        session()->flash('success', $request->name.' User created successfully');
        return redirect()->route('account.login');


    }
    public function authenticate(Request $request){
       $validator= $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
       if($validator){
          if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password],$request->get('remember'))){
              if (session()->has('url.intended')) {
                  $intendedUrl = session()->get('url.intended');
                  session()->forget('url.intended'); // Delete the intended URL from session
                  return redirect($intendedUrl);
              }
                session()->flash('success', 'User logged in successfully');
                return redirect()->route('account.profile');

          }else{
              session()->flash('error', 'Invalid email or password');
              return redirect()->route('account.login')->withInput($request->only('email', 'remember'));


          }

       }else{
           session()->flash('error', 'Invalid email or password');
              return redirect()->route('account.login')->withInput($request->only('email', 'remember'));

       }



    }
    public function profile(){
        return view('front.account.profile');

    }
    public function logout(){
        Auth::logout();
        session()->flash('success', 'User logged out successfully');
        return redirect()->route('account.login');

    }

}
