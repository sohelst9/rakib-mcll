<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TotalBalance;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //--dashboard
    public function dashboard()
    {
        $total_games = Tournament::count() + 1;
        $games = Tournament::with('category')->take(3)->get();
        $total_users = User::count();
        $total_users_balance = TotalBalance::sum('balance');
        return view('Admin.index', compact('total_games', 'total_users', 'games', 'total_users_balance'));
    }

    //--logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}
