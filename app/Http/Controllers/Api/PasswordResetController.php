<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    //--forgot_sendOtp
    public function forgot_sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $phone = preg_replace('/^\+?88/', '', $request->phone);
        $user = User::where('phone', $phone)->first();
        if ($user) {
            $otp = rand(100000, 999999);
            ResetOtp::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);

            $message = "Dear Customer, {$otp} is your one time password (OTP). Please enter the OTP to proceed.\n\nThank you.";
            $url = "http://sms.joypurhost.com/api/smsapi?api_key=lEHIet1hTPvMf94Bpwl2&type=text&number={$phone}&senderid=8809617624788&message={$message}";
            $response = Http::get($url);
            return response()->json([
                'status' => 200,
                'message' => 'OTP sent successfully.'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        }
    }

    //--- forgot_verifyOtp
    public function forgot_verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $phone = preg_replace('/^\+?88/', '', $request->phone);
        $user = User::where('phone', $phone)->first();
        if ($user) {
             $otpRecord = ResetOtp::where('user_id', $user->id)
                ->where('otp', $request->otp)
                ->first();
            if($otpRecord){
                $otpRecord->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'OTP verified successfully.'
                ], 200);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid OTP'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        }
    }

    //-- forgot_resetPassword
    public function forgot_resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
        ]);

        $phone = preg_replace('/^\+?88/', '', $request->phone);
        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        if($request->password != $request->confirm_password){
            return response()->json([
                'status' => 400,
                'message' => 'Password and confirm password do not match'
            ], 400);
        }

        $user = User::where('phone', $phone)->first();
        if($user){
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => 'Password reset successfully.'
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ], 404);
        }

    }
}
