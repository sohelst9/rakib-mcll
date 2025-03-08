<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllTransactionController extends Controller
{
    //--alltrnx
    public function alltrnx(Request $request)
    {
        $search = $request->input('search');
        $allTrnsactions = DB::table('tournament_payment_details')
            ->select(
                'tournament_payment_details.id as transaction_id', // Alias added
                'tournament_payment_details.user_id',
                'users.name as user_name', // User name
                'tournament_payment_details.title',
                'tournament_payment_details.trnx_type',
                'tournament_payment_details.amount',
                'tournament_payment_details.trnx_id',
                'tournament_payment_details.status',
                'tournament_payment_details.trnx_date',
                'tournament_payment_details.created_at'
            )
            ->join('users', 'tournament_payment_details.user_id', '=', 'users.id')
            ->where('users.name', 'LIKE', "%{$search}%")
            ->orWhere('tournament_payment_details.title', 'LIKE', "%{$search}%")
            ->orWhere('tournament_payment_details.trnx_type', 'LIKE', "%{$search}%")
            ->orWhere('tournament_payment_details.trnx_id', 'LIKE', "%{$search}%")
            ->unionAll(
                DB::table('add_cashes')
                    ->select(
                        'add_cashes.id as transaction_id', // Alias added
                        'add_cashes.user_id',
                        'users.name as user_name', // User name
                        'add_cashes.title',
                        'add_cashes.trnx_type',
                        'add_cashes.amount',
                        'add_cashes.trnx_id',
                        'add_cashes.status',
                        'add_cashes.trnx_date',
                        'add_cashes.created_at'
                    )
                    ->join('users', 'add_cashes.user_id', '=', 'users.id')
                    ->where('users.name', 'LIKE', "%{$search}%")
                    ->orWhere('add_cashes.title', 'LIKE', "%{$search}%")
                    ->orWhere('add_cashes.trnx_type', 'LIKE', "%{$search}%")
                    ->orWhere('add_cashes.trnx_id', 'LIKE', "%{$search}%")
            )
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('Admin.accounts.alltrnx.alltrnx', compact('allTrnsactions'));
    }
}
