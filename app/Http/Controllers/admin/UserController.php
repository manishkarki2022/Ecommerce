<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest('id')->paginate(10);
        return view('admin.user.index', compact('users'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Query to search users based on name, email, and phone
        $users = User::where(function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhere('phone', 'like', '%' . $keyword . '%');
        })->latest('id')->paginate(10);

        // Pass the search results to the view
        return view('admin.user.index', compact('users'));
    }
    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'password' => 'required|min:6',
            'cpassword' => 'required|same:password'
        ]);
       if($validate){
           $user = new User();
           $user->name = $request->name;
           $user->email = $request->email;
           $user->phone = $request->phone;
           $user->status = $request->status;
           $user->password = bcrypt($request->password);
           $user->save();
           return redirect()->route('users.index')->with('success', 'User created successfully.');
       }else{
           return redirect()->back()->with('error', 'Something went wrong');
       }
    }


//    public function show($id){
//        $user = User::find($id);
//        return view('admin.user.show', compact('user'));
//
//    }
}
