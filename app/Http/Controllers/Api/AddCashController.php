<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AddCash;
use App\Models\Admin\Cashback;
use App\Models\TotalBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddCashController extends Controller
{

    //---getCashbackMessage
    public function getCashbackMessage(Request $request)
    {
        $amount = $request->amount;
        $offer_id = $request->offer_id;
        $cashbackAmount = 0;
        $message = '';

        if ($offer_id) {
            $offer = Cashback::where('id', $offer_id)
                ->where('status', 1)
                ->first();

            if ($offer) {
                $cashbackAmount = $offer->cashback_amount;
                $message = "You get {$cashbackAmount} extra!";
            } else {
                $message = "No valid cashback offer found.";
            }
        } elseif ($amount) {
            $offer = Cashback::where('status', 1)
                ->whereRaw('amount = ?', [$amount])
                ->first();

            if ($offer) {
                $cashbackAmount = $offer->cashback_amount;
                $message = "You get {$cashbackAmount} extra!";
            } else {
                $message = "No valid cashback offer found.";
            }
        } else {
            $message = "Please select a offer or enter a valid amount.";
        }

        return response()
            ->json([
                'success' => true,
                'message' => $message,
                'cashback_amount' => $cashbackAmount
            ]);
    }
    //--addCash
    public function addCash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            // 'payment_method' => 'required',
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
            $add_cash = new AddCash();
            $add_cash->user_id = $request->user_id;
            $add_cash->payment_type = 'deposit';
            $add_cash->title = $request->title;
            $add_cash->amount = $request->amount;
            $add_cash->payment_method = $request->payment_method;
            $add_cash->trnx_type = $request->trnx_type;
            $add_cash->trnx_id = $request->trnx_id;
            $add_cash->trnx_date = $request->trnx_date;
            $add_cash->cashback_amount = $request->cashback_amount ?? 0;
            $add_cash->status = 1;

            $totalAmount = (int) $request->amount + (int) ($request->cashback_amount ?? 0);
            if ($add_cash->save()) {
                $user_balance = TotalBalance::where('user_id', $request->user_id)->first();
                $user_balance->balance = $user_balance->balance + $totalAmount;
                $user_balance->save();
                return response()->json(['message' => 'Cash Added Successfully']);
            }
        }
    }
}
