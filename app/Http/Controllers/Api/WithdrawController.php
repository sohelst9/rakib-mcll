<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TotalBalance;
use App\Models\User;
use App\Models\WiningBalance;
use App\Models\Withdraw;
use App\Models\WithdrawNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WithdrawController extends Controller
{
    //--withdrawRequest
    public function withdrawRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'withdraw_number_id' => 'required',
            'amount' => 'required',
            'trnx_id' => 'required',
            'trnx_date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        } else {

            $total_balance = TotalBalance::where('user_id', $request->user_id)->first();
            $total_wining_balance = WiningBalance::where('user_id', $request->user_id)->first();
            if ($request->amount >= 100 && $request->amount <= 1000) {
                if ($total_wining_balance->balance >= $request->amount) {
                    $withdraw = new Withdraw();
                    $withdraw->user_id = $request->user_id;
                    $withdraw->withdraw_number_id = $request->withdraw_number_id;
                    $withdraw->payment_type = "Withdraw";
                    $withdraw->title = "Cash Withdraw";
                    $withdraw->amount = $request->amount;
                    $withdraw->payment_method = $request->payment_method;
                    $withdraw->trnx_type = "Withdraw";
                    $withdraw->trnx_id = $request->trnx_id;
                    $withdraw->trnx_date = $request->trnx_date;
                    $withdraw->status = 0;

                    if ($withdraw->save()) {

                        $total_wining_balance->decrement('balance', $request->amount);
                        $total_balance->decrement('balance', $request->amount);
                        return response()->json(['message' => 'Withdraw Request Sent Successfully'], 200);
                    }
                } else {
                    return response()->json([
                        'error' => 'insufficient_balance',
                        'message' => 'Not enough balance to complete the transaction.'
                    ], 422);
                }
            } else {
                return response()->json([
                    'status' => 'amount_not_valid',
                    'message' => 'Withdraw amount must be between 100 Tk and 1000 Tk.'
                ], 422);
            }
        }
    }

    //--withdrawNumberSave
    public function withdrawNumberSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        } else {
            $existsNumber = WithdrawNumber::where('user_id', $request->user_id)->first();
            if ($existsNumber) {
                return response()->json([
                    'error' => 'This user number already exists.'
                ], 422);
            } else {
                $withdrawNumber = new WithdrawNumber();
                $withdrawNumber->user_id = $request->user_id;
                $withdrawNumber->number = $request->number;
                if ($withdrawNumber->save()) {
                    return response()->json(['message' => 'Withdraw Number Saved Successfully'], 200);
                }
            }
        }
    }

    //--withdrawNumberGet
    public function withdrawNumberGet()
    {
        $user = Auth::user();
        $withdrawNumber = WithdrawNumber::where('user_id', $user->id)->first();
        if ($withdrawNumber) {
            return response()->json([
                'status' => 200,
                'id' => $withdrawNumber->id,
                'withdrawNumber' => $withdrawNumber->number
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'withdrawNumber' => 'Not Found'
            ], 404);
        }
    }


    //--withdrawUserTrnx
    public function withdrawUserTrnx(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        if ($user) {
            $withdraws = Withdraw::where('user_id', $user->id)->latest()->get();
            return response()->json([
                'status' => 200,
                'withdraws' => $withdraws->map(function ($withdraw) {
                    return [
                        'id' => $withdraw->id,
                        'user_name' => $withdraw->user ? $withdraw->user->name : '',
                        'title' => $withdraw->title,
                        'payment_type' => $withdraw->payment_type,
                        'amount' => $withdraw->amount,
                        'payment_method' => $withdraw->payment_method,
                        'trnx_id' => $withdraw->trnx_id,
                        'trnx_date' => $withdraw->trnx_date,
                        'status' => $withdraw->status == 1 ? 'COMPLETE' : 'PENDING',

                    ];
                })
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'error' => 'User Not Found'
            ], 404);
        }
    }
}
