<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BattlePaymentDetails;
use App\Models\TotalBalance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BattleGameController extends Controller
{
    //---get_user
    public function get_user(Request $request)
    {
        $token = $request->token;
        $user = User::where('access_token', $token)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json([
            'token' => $user->access_token,
            'name' => $user->name,
            'avatar' => $user->profile ? asset('profile/' . $user->profile) : asset('profile/user-3.jpg'),
            'coins' => $user->totalbalance->balance,
        ]);
    }

    //--update_user
    public function update_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'amount' => 'required',
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $user = User::where('access_token', $request->token)->with('totalbalance')->first();
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        } else {
            $total_balance = $user->totalbalance?->balance ?? 0;
            $wining_balance = $user->winingbalance?->balance ?? 0;
            //-- join game login
            if ($request->type == 'join') {
                $result =  DB::transaction(function () use ($user, $request, $total_balance, $wining_balance) {

                    $required_amount = $request->amount;
                    $non_wining_balance = $total_balance - $wining_balance;


                    //-- first user total balance check--

                    //-- without wining balance because total balance greater than or equal required amount
                    if ($non_wining_balance >= $request->amount) {
                        $user->totalbalance()->decrement('balance', $request->amount);
                    } elseif ($total_balance >= $request->amount) {
                        $user->totalbalance()->decrement('balance', $request->amount);
                        //-- decrement wining balance--
                        $used_wining_balance = $request->amount - $non_wining_balance;
                        $user->winingbalance()->decrement('balance', $used_wining_balance);
                    } else {
                        return 'insufficient_balance';
                    }


                    //-- create transaction
                    $ballte_payment_details = new BattlePaymentDetails();
                    $ballte_payment_details->user_id = $user->id;
                    $ballte_payment_details->payment_type = 'Battle';
                    $ballte_payment_details->title = 'Join Battle Game';
                    $ballte_payment_details->amount = $request->amount;
                    $ballte_payment_details->payment_method = 'balance';
                    $ballte_payment_details->trnx_type = 'Join';
                    $ballte_payment_details->trnx_id = 'Battle-' . rand(1000, 9999);
                    $ballte_payment_details->trnx_date = date('Y-m-d');
                    $ballte_payment_details->status = 1;
                    $ballte_payment_details->save();

                    return 'success';
                });

                //-- return response
                if ($result == 'success') {
                    return response()->json([
                        'status' => 200,
                        'type' => 'join',
                        'message' => 'Game joined successfully',
                    ], 200);
                } elseif ($result == 'insufficient_balance') {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Insufficient balance'
                    ], 400);
                }
            } elseif ($request->type == 'win') {
                $result =  DB::transaction(function () use ($user, $request) {

                    $user->totalbalance()->increment('balance', $request->amount);
                    $user->winingbalance()->increment('balance', $request->amount);
                    //-- create transaction
                    $ballte_payment_details = new BattlePaymentDetails();
                    $ballte_payment_details->user_id = $user->id;
                    $ballte_payment_details->payment_type = 'Battle';
                    $ballte_payment_details->title = 'Win Battle Game';
                    $ballte_payment_details->amount = $request->amount;
                    $ballte_payment_details->payment_method = 'balance';
                    $ballte_payment_details->trnx_type = 'Win';
                    $ballte_payment_details->trnx_id = 'Battle-' . rand(1000, 9999);
                    $ballte_payment_details->trnx_date = date('Y-m-d');
                    $ballte_payment_details->status = 1;
                    $ballte_payment_details->save();
                    return 'success';
                });

                if ($result == 'success') {
                    return response()->json([
                        'status' => 200,
                        'type' => 'win',
                        'message' => 'Congratulations! You won the game!',
                    ], 200);
                }
            }
        }
    }
}
