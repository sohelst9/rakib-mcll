<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionsResource;
use App\Models\TournamentPaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //--transactions
    public function transactions(Request $request)
    {
        $user_id = Auth::user()->id;
        // $transcations = TournamentPaymentDetails::where('user_id', $request->user_id)->latest()->get();
        $transcations = DB::table('tournament_payment_details')
            ->select('id', 'user_id', 'title', 'trnx_type', 'amount', 'trnx_id', 'status', 'trnx_date', 'created_at')
            ->where('user_id', $user_id)
            ->unionAll(
                DB::table('add_cashes')
                    ->select('id', 'user_id', 'title', 'trnx_type', 'amount', 'trnx_id', 'status', 'trnx_date', 'created_at')
                    ->where('user_id', $user_id)
            )
            ->unionAll(
                DB::table('withdraws')
                    ->select('id', 'user_id', 'title', 'trnx_type', 'amount', 'trnx_id', 'status', 'trnx_date', 'created_at')
                    ->where('user_id', $user_id)
            )
            ->unionAll(
                DB::table('battle_payment_details')
                    ->select('id', 'user_id', 'title', 'trnx_type', 'amount', 'trnx_id', 'status', 'trnx_date', 'created_at')
                    ->where('user_id', $user_id)
            )
            ->unionAll(
                DB::table('tournament_wining_payment_details')
                    ->select('id', 'user_id', 'title', 'trnx_type', 'amount', 'trnx_id', 'status', 'trnx_date', 'created_at')
                    ->where('user_id', $user_id)
            )
            ->orderBy('created_at', 'desc')
            ->get();
        return TransactionsResource::collection($transcations);
    }
}
