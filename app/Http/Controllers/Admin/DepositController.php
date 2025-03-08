<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddCash;
use App\Models\TotalBalance;
use App\Models\User;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    //--index
    public function index(Request $request)
    {
        $search = $request->input('search');
        $deposits = AddCash::latest()->with('user')->paginate(20);
        return view('Admin.accounts.deposits.index', compact('deposits'));
    }

    //-- payment_status
    public function payment_status(AddCash $addcash)
    {
        $totalAmount = (int) $addcash->amount + (int) ($addcash->cashback_amount ?? 0);
        $addcash->status = $addcash->status == 1 ? 0 : 1;
        if ($addcash->save()) {
            $user_balance = TotalBalance::where('user_id', $addcash->user_id)->first();
            $user_balance->balance = $user_balance->balance + $totalAmount;
            $user_balance->save();
        }
        return redirect()->back()->with('success', 'Payment status updated successfully');
    }

    //-add_cash
    public function add_cash(Request $request)
    {
        $users = User::get();
        return view('Admin.accounts.add-cash.add_cash', compact('users'));
    }

    //-add_cash_update
    public function add_cash_update(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'title' => 'required',
            'add_amount' => 'required',
            'date' => 'required',
        ]);

        $uinque_trnx_id = 'trnx_' . rand(100000, 999999);
         $uinque_trnx_id;

        $addcash = new AddCash();
        $addcash->user_id = $request->user;
        $addcash->payment_type = 'deposit';
        $addcash->title = $request->title;
        $addcash->amount = $request->add_amount;
        $addcash->payment_method = 'admin';
        $addcash->trnx_type = 'deposit';
        $addcash->trnx_id = $uinque_trnx_id;
        $addcash->trnx_date = $request->date;
        $addcash->status = 1;
        if($addcash->save()){
            $total_balance = TotalBalance::where('user_id', $request->user)->first();
            //--use increment method to add the amount to the balance
            $total_balance->increment('balance', $request->add_amount);
            return redirect()->back()->with('success', 'Amount added successfully');
        }
    }
}
