<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //--profile
    public function profile()
    {
        $user = Auth::guard('admin')->user();
        return view('Admin.auth.profile', compact('user'));
    }

    // ---update profile
    public function profile_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'profile' => 'nullable|mimes:jpg,jpeg,png,gif,svg,webp|max:200',
        ]);

        $user_id = Auth::guard('admin')->user()->id;
        $user = Admin::find($user_id);
        $user->name = $request->name;
        if ($request->hasFile('profile')) {
            // Delete the old profile image if it exists
            if ($user->profile && file_exists(public_path('admin/user/' . $user->profile))) {
                unlink(public_path('admin/user/' . $user->profile));
            }

            $file = $request->file('profile');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/user'), $filename);
            $user->profile = $filename;

            if ($user->save()) {
                return redirect()->back()->with('success', 'Profile updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to update profile');
            }
        }
    }

    //-- password_update
    public function password_update(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
        ]);

        if ($request->password == $request->confirm_password) {
            $user_id = Auth::guard('admin')->user()->id;
            $user = Admin::find($user_id);
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return redirect()->back()->with('success', 'Password updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to update password');
            }
        } else {
            return redirect()->back()->with('error', 'Password and confirm password do not match');
        }
    }
}
