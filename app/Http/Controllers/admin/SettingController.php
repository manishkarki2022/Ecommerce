<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('admin.change-password');
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
        $user = User::where('id',Auth::guard('admin')->user()->id)->first();

        // Check if the old password matches the user's current password
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'The old password is incorrect.');
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect back with success message
        return redirect()->route('admin.showChangePassword')->with('success', 'Password changed successfully.');
    }

}
