<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use App\Models\WithdrawNumber;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    //--index
    public function index()
    {
        $withdraws = Withdraw::latest()->with('user', 'withdraw_number')->paginate(20);
        return view('Admin.accounts.withdraw.index', compact('withdraws'));
    }

    //--updateTrnxId
    public function updateTrnxId(Request $request, $id)
    {
        $request->validate([
            'trnx_id' => 'required|string|max:255'
        ]);

        $withdraw = Withdraw::findOrFail($id);
        $withdraw->trnx_id = $request->trnx_id;
        $withdraw->save();

        return response()->json(['success' => true, 'message' => 'Transaction ID Updated Successfully!']);
    }

    //-- withdraw_status
    public function withdraw_status($id)
    {
        $withdraw = Withdraw::find($id);
        if($withdraw){
            $withdraw->status = 1;
            $withdraw->save();
            return redirect()->back()->with('success', 'Withdraw status updated successfully');
        }
    }


    //--withdraws_number
    public function withdraws_number(Request $request)
    {
        $search = $request->input('search');
        $query = WithdrawNumber::latest()->with('user');
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })->orWhere('number', 'LIKE', "%{$search}%");
        }
        $withdraw_numbers = $query->paginate(20);
        return view('Admin.accounts.withdraw.withdraw_number', compact('withdraw_numbers'));
    }

    //--withdraws_number_edit
    public function withdraws_number_edit($id)
    {
        $withdraw_number = WithdrawNumber::find($id);
        return view('Admin.accounts.withdraw.withdraw_number_edit', compact('withdraw_number'));
    }

    //---withdraws_number_update
    public function withdraws_number_update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required'
        ]);
        $withdraw_number = WithdrawNumber::find($id);
        $withdraw_number->update($request->all());
        return redirect()->route('admin.withdraws.number')->with('success', 'Withdraw Number Updated Successfully');
    }

    //--withdraws_number_delete
    public function withdraws_number_delete($id)
    {
        WithdrawNumber::find($id)->delete();
        return redirect()->route('admin.withdraws.number')->with('success', 'Withdraw Number Deleted Successfully');
    }
}
