<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TournamentGameResource;
use App\Http\Resources\TournamentPriceResource;
use App\Models\TotalBalance;
use App\Models\Tournament;
use App\Models\TournamentPaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TournamentController extends Controller
{
    //--tournamentGames
    public function tournamentGames(Request $request)
    {
         $games = Tournament::withCount(['tournament_payment_details'])
            ->withSum('tournament_prices', 'price')
            ->where('status', 1)
            ->get();
        return TournamentGameResource::collection($games);
    }

    //-- tournamentPrices
    public function tournamentPrices($slug)
    {
        $game = Tournament::where('slug', $slug)->with('tournament_prices')->first();
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        } else {
            return TournamentPriceResource::collection($game->tournament_prices);
        }
    }

    //--tournamentPayment
    public function tournamentPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'tournament_id' => 'required',
            'amount' => 'required',
            'trnx_id' => 'required',
            'trnx_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $user_balance = TotalBalance::where('user_id', $request->user_id)->first();
            $trnx_exists = TournamentPaymentDetails::where('user_id', $request->user_id)->where('tournament_id', $request->tournament_id)->first();
            if ($trnx_exists) {
                return response()->json(['message' => 'Transaction already exists'], 422);
            } else {
                if ($user_balance->balance >= $request->amount) {
                    $tournament_payments = new TournamentPaymentDetails();
                    $tournament_payments->user_id = $request->user_id;
                    $tournament_payments->tournament_id = $request->tournament_id;
                    $tournament_payments->payment_type = "tournament";
                    $tournament_payments->title = $request->title;
                    $tournament_payments->amount = $request->amount;
                    $tournament_payments->payment_method = $request->payment_method;
                    $tournament_payments->trnx_type = $request->trnx_type;
                    $tournament_payments->trnx_id = $request->trnx_id;
                    $tournament_payments->trnx_date = $request->trnx_date;
                    $tournament_payments->status = 1;
                    if ($tournament_payments->save()) {
                        $user_balance->balance = $user_balance->balance - $request->amount;
                        $user_balance->save();
                        return response()->json(['message' => 'Payment successful'], 200);
                    }
                } else {
                    return response()->json(
                        [
                            'status' => 400,
                            'message' => 'Insufficient balance'
                        ],
                        400
                    );
                }
            }
        }
    }

    //-- tournamentsingleGame
    public function tournamentSingleGame(Tournament $tournament)
    {
        $tournament->loadCount('tournament_payment_details');
        return new TournamentGameResource($tournament);
    }

    //--checkPayment
    public function checkPayment($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        if (isset($tournament)) {
            $user_id = Auth::user()->id;
            $payment_details = TournamentPaymentDetails::where('user_id', $user_id)->where('tournament_id', $tournament->id)->first();
            if ($payment_details) {
                return response()->json(
                    [
                        'status' => 'joined',
                        'message' => 'You have already joined this tournament!'
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => 'not_joined',
                        'message' => 'You have not joined this tournament!'
                    ],
                    200
                );
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Tournament Game not found!'
            ], 404);
        }
    }
}
