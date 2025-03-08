<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReferrController extends Controller
{
    //---refer_list
    public function refer_list(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        })
        ->orderByDesc('refer_count') 
        ->paginate(20)
        ->withQueryString();

        return view('Admin.refer.index', compact('users', 'search'));
    }

    //--refer_clear 
    public function refer_clear()
    {
        //--all users refer_count field value 0
        User::query()->update(['refer_count' => 0]);
        return redirect()->back()->with('success', 'All users refer count cleared');
        
    }
    
}
