<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AddCash;
use App\Models\TotalBalance;
use App\Models\User;
use App\Models\WiningBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManageController extends Controller
{
    //--- authentication user show
    public function user(Request $request)
    {
        $user = Auth::user();
        //    return $userData = User::where('id', $user->id)->with('winingbalance', 'totalbalance')->first();
        $total_balance = TotalBalance::where('user_id', $user->id)->first()->balance;
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'profile' => $user->profile ? asset('profile/' . $user->profile) : null,
            'refer_code' => $user->refer_code,
            'refer' => $user->refer,
            'access_token' => $user->access_token,
            'is_block' => $user->is_block == 0 ? 'block' : 'unblock',
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'total_balance' => $total_balance,
        ]);
    }

    //--totalbalance
    public function totalbalance()
    {
        $total_balance = TotalBalance::where('user_id', Auth::user()->id)->first();
        return response()->json([
            'total_balance' => $total_balance->balance
        ]);
    }

    //-- user_wallet
    public function user_wallet()
    {
        $user = Auth::user();
        $total_balance = TotalBalance::where('user_id', $user->id)->first()->balance;
        $total_wining_balance = WiningBalance::where('user_id', $user->id)->first()->balance;
        $total_deposits = AddCash::where('user_id', $user->id)->sum('amount');
        $total_wining = 0;
        $total_token = 0;
        return response()->json([
            'total_balance' => $total_balance,
            'total_deposits' => $total_balance,
            'total_wining' => $total_wining_balance,
            'total_token' => $total_token,
        ]);
    }


    //--refer_list
    public function refer_list()
    {
        $authUser = Auth::user();


        $users = User::orderByDesc('refer_count')->get();
        $users->each(function ($user, $index) {
            $user->referrals_count = $user->refer_count;
            $user->rank = $index + 1;
        });

        $myRank = $users->firstWhere('id', $authUser->id);

        return response()->json([
            'myRank' => $myRank,
            'users' => $users
        ]);
    }
}
