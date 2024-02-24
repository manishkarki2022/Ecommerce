<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index()
    {

       return view('admin.login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            $credentials = $request->only('email', 'password');

            if (Auth::guard('admin')->attempt($credentials, $request->get('remember'))) {
                $user = Auth::guard('admin')->user();
                if($user->role == 2){
                    return redirect()->route('admin.dashboard');
                }
                else{
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')
                        ->with('error', 'You are not authorized to access this page.')
                        ->withInput($request->only('email', 'password'));
                }
            }



            return redirect()->route('admin.login')
                ->with('error', 'Invalid Credentials')
                ->withInput($request->only('email', 'password'));
        }
        return redirect()->route('admin.login')
            ->withErrors($validator)
            ->withInput($request->only('email', 'password'));
    }
}
