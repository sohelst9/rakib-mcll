<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //--index
    public function index()
    {
        $setting = Setting::first();
        return view('Admin.setting', compact('setting'));
    }

    //--update_setting
    public function update_setting(Request $request, $id)
    {
        $request->validate([
            'app_name' => 'required',
            'withdraw_status' => 'required',
        ]);

        $setting = Setting::find($id);
        if($setting){
            $setting->app_name = $request->app_name;
            $setting->withdraw_status = $request->withdraw_status;
            $setting->save();
            return redirect()->back()->with('success', 'Setting updated Successfully');
        }
        return redirect()->back()->with('success', 'Setting Updated Failed');
    }
}
