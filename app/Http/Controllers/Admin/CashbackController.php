<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cashback;
use Illuminate\Http\Request;

class CashbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashbacks = Cashback::all();
        return view('Admin.accounts.deposit_cashback.index', compact('cashbacks'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'cashback_amount' => 'required|numeric',
        ]);
        Cashback::create($request->all());
        return redirect()->back()->with('success', 'Cashback created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cashback = Cashback::find($id);
        return view('Admin.accounts.deposit_cashback.edit', compact('cashback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'cashback_amount' => 'required|numeric',
        ]);
        $cashback = Cashback::find($id);
        $cashback->update($request->all());
        return redirect()->route('cashback.index')->with('success', 'Cashback updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cashback = Cashback::find($id);
        $cashback->delete();
        return redirect()->back()->with('success', 'Cashback deleted successfully');
    }


    //--- status
    public function status($id)
    {
        $cashback = Cashback::find($id);
        $cashback->status = $cashback->status == 1 ? 0 : 1;
        $cashback->save();
        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
