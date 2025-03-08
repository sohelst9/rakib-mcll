<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cashback;
use Illuminate\Http\Request;

class CashbackController extends Controller
{
    //--cashback
    public function cashback(Request $request)
    {
        $offers = Cashback::orderBy('amount', 'asc')
            ->where('status', 1)
            ->get();
        return response()->json([
            'offers' => $offers,
        ]);
    }
}
