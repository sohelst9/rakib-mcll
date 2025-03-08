<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\TournamentPrice;
use App\Models\TotalBalance;
use App\Models\Tournament;
use App\Models\TournamentPaymentDetails;
use App\Models\TournamentScore;
use App\Models\TournamentWiningPaymentDetails;
use App\Models\User;
use App\Models\WiningBalance;
use App\Models\WithdrawNumber;
use Illuminate\Http\Request;

class TournamentPaymentController extends Controller
{
    //---tournament_payment
    public function tournament_payment($slug)
    {
        $tGame = Tournament::where('slug', $slug)->first();
        $join_users = TournamentPaymentDetails::where('tournament_id', $tGame->id)->with('user', 'tournament')->get();
        $prices = TournamentPrice::where('tournament_id', $tGame->id)->get();
        $tournamentScores = TournamentScore::where('tournament_id', $tGame->id)
            ->join('users', 'tournament_scores.user_id', '=', 'users.id')
            ->join('tournaments', 'tournament_scores.tournament_id', '=', 'tournaments.id')
            ->select('tournament_scores.user_id', 'users.name as user_name', 'tournaments.name as tournament_name', 'tournament_scores.score')
            ->orderByDesc('tournament_scores.score')
            ->take(20)
            ->get();
        return view('Admin.game.tournamentGame.payment.create', compact('tGame', 'join_users', 'prices', 'tournamentScores'));
    }

    //--get_user_withdraw_number
    public function get_user_withdraw_number($user_id)
    {
        $withdraw_number = WithdrawNumber::where('user_id', $user_id)->first();
        if ($withdraw_number) {
            return response()->json($withdraw_number);
        }
        return response()->json(['number' => null], 200);
    }

    //---tournament_payment_store
    public function tournament_payment_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required'
        ]);

        //-- 8 digit unique token --
        $trnx_id = rand(10000000, 99999999);
        // return $request->all();
        $tournament_payments = new TournamentWiningPaymentDetails();
        $tournament_payments->user_id = $request->name;
        $tournament_payments->tournament_id = $request->tgame_id;
        $tournament_payments->payment_type = "Tournament Wining";
        $tournament_payments->title = "Tournament Wining";
        $tournament_payments->amount = $request->amount;
        $tournament_payments->payment_method = "NA";
        $tournament_payments->trnx_type = 'Tournament Wining';
        $tournament_payments->trnx_id = $trnx_id;
        $tournament_payments->trnx_date = date('Y-m-d');
        $tournament_payments->status = 1;
        if($tournament_payments->save()){
            //-- add amount wining balance and total balance ---
            $total_balance = TotalBalance::where('user_id', $request->name)->first();
            $wining_balance = WiningBalance::where('user_id', $request->name)->first();
            $total_balance->increment('balance', $request->amount);
            $wining_balance->increment('balance', $request->amount);
            return back()->with('success', 'Tournament Wining Payment Successfully');
        }
    }

    //--tournament_payment_list
    public function twining_payment_list()
    {
        $tournament_payment_lists = TournamentWiningPaymentDetails::with('user', 'tournament')->latest()->get();
        return view('Admin.game.tournamentGame.payment.index', compact('tournament_payment_lists'));
    }
}
