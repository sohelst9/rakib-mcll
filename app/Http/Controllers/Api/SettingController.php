<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //--setting
    public function setting(Request $request)
    {
        $setting = Setting::first();
        return response()->json([
            'app_name' => $setting->app_name,
            'withdraw_status' => $setting->withdraw_status == 0 ? 'off' : 'on',
        ]);
    }
}
