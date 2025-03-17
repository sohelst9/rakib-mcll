<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    //---userlists
    public function userlists(Request $request)
    {
        $users = User::latest()
            ->with('totalbalance')
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('phone', 'LIKE', '%' . $request->search . '%')
            ->paginate(50);
        return view('Admin.user.index', compact('users'));
    }

    //---deleteUser
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $imagePath = public_path('profile/' . $user->profile);
            if ($user->profile && file_exists(public_path($imagePath))) {
                unlink($imagePath);
            }
            $user->totalbalance()->delete();
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully');
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
    }

    //--blockUser
    public function blockUser($id)
    {
        $user = User::find($id);
        if ($user) {
            //--block unblock user change is_otp_verified 1 and 0
            if ($user->is_block == 1) {
                $user->is_block = 0;
                $user->is_login = 0;
                $user->save();
                //-- user all token delete --
                $user->tokens()->delete();
                return redirect()->back()->with('success', 'User blocked successfully');
            } else {
                $user->is_block = 1;
                $user->save();
                return redirect()->back()->with('success', 'User unblocked successfully');
            }
        }
    }
}
