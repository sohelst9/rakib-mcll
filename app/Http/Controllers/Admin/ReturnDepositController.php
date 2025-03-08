<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnDeposit;
use App\Models\TotalBalance;
use App\Models\User;
use Illuminate\Http\Request;

class ReturnDepositController extends Controller
{
    //--return_deposit
    public function return_cash()
    {
        $users = User::with('totalbalance')->get();
        $returndatas = ReturnDeposit::with('user')->latest()->paginate(20);
        return view('Admin.accounts.return_deposit.index', compact('users', 'returndatas'));
    }

    //--return_cash_store
    public function return_cash_store(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'return_amount' => 'required'
        ]);

        $total_balance = TotalBalance::where('user_id', $request->user)->first();
        if ($total_balance) {
            if ($request->return_amount > $total_balance->balance) {
                return redirect()->back()->with('error', 'Return deposit amount cannot be greater than the user\'s total balance');
            } else {
                $return_deposit = new ReturnDeposit();
                $return_deposit->user_id = $request->user;
                $return_deposit->return_amount = $request->return_amount;
                $return_deposit->status = 1;
                if ($return_deposit->save()) {
                    $total_balance->balance -= $request->return_amount;
                    $total_balance->save();
                    return redirect()->back()->with('success', 'Return deposit amount has been successfully added');
                }
            }
        } else {
            return redirect()->back()->with('error', 'User does not have any balance');
        }
    }

    //--return_cash_edit
    public function return_cash_edit($id)
    {
        $users = User::with('totalbalance')->get();
        $return_deposit = ReturnDeposit::findOrFail($id);
        return view('Admin.accounts.return_deposit.edit', [
            'users' => $users,
            'return_deposit' => $return_deposit
        ]);
    }

    //--return_cash_update
    public function return_cash_update(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'return_amount' => 'required'
        ]);

        $return_deposit = ReturnDeposit::findOrFail($id);
        $total_balance = TotalBalance::where('user_id', $return_deposit->user_id)->first();
        if ($total_balance) {
            if ($request->return_amount > $total_balance->balance) {
                return redirect()->back()->with('error', 'Return deposit amount cannot be greater than the user\'s total balance');
            }else{
                $total_balance->balance += $return_deposit->return_amount;
                $return_deposit->return_amount = $request->return_amount;
                $return_deposit->status = 1;
                if ($return_deposit->save()) {
                    $total_balance->balance -= $request->return_amount;
                    $total_balance->save();
                    return redirect()->back()->with('success', 'Return deposit amount has been successfully updated');
                }
            }
        } else {
            return redirect()->back()->with('error', 'User does not have any balance');
        }
    }
}
