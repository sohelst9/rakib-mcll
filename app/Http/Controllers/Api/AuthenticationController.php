<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\TotalBalance;
use App\Models\User;
use App\Models\WiningBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{
    public function sendOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => [
                'required',
                'regex:/^(\+88|88)?01[3-9]\d{8}$/',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Remove +88 or 88 from phone number and save in correct format
        $phone = preg_replace('/^(\+88|88)/', '', $request->phone);

        // Check if user exists
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            $otp = rand(100000, 999999);
            $expiresAt = Carbon::now()->addMinutes(5);

            Otp::updateOrCreate(
                ['phone' => $phone],
                ['otp' => $otp, 'expires_at' => $expiresAt]
            );

            $message = 'Your OTP is ' . $otp;
            $url = "http://bulksmsbd.net/api/smsapi?api_key=XBb5aTHdQrAquQ7Q4OSd&type=text&number={$phone}&senderid=8809617624524&message={$message}";
            $response = Http::get($url);

            return response()->json(
                [
                    'phone' => $phone,
                    'status' => "number_not_exists",
                    'message' => 'OTP sent successfully!.'
                ]
            );
        } else {
            if (!$user->is_otp_verified) {
                $otp = rand(100000, 999999);
                $expiresAt = Carbon::now()->addMinutes(5);

                Otp::updateOrCreate(
                    ['phone' => $phone],
                    ['otp' => $otp, 'expires_at' => $expiresAt]
                );

                // Delete old personal access tokens
                $user->tokens()->delete();

                $message = 'Your OTP is ' . $otp;
                $url = "http://bulksmsbd.net/api/smsapi?api_key=XBb5aTHdQrAquQ7Q4OSd&type=text&number={$phone}&senderid=8809617624524&message={$message}";
                $response = Http::get($url);
                return response()->json(
                    [
                        'phone' => $phone,
                        'status' => "number_not_exists",
                        'message' => 'OTP sent successfully!.'
                    ]
                );
            } else {
                // If user exists and otp verify , direct to password page for login
                return response()->json([
                    'phone' => $phone,
                    'status' => "number_exists",
                    'message' => 'Phone number exists. Please enter your password to login.'
                ]);
            }
        }
    }

    //--verify otp
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $phone = str_replace('+88', '', $request->phone);

        $otpRecord = Otp::where('phone', $phone)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid OTP or Number.'], 401);
        }

        if ($otpRecord->expires_at < now()) {
            return response()->json(['message' => 'OTP expired.'], 401);
        }

        // Check if user already exists or create a new user
        $user = User::where('phone', $phone)->first();
        if (!$user) {
            $user = User::create([
                'phone' => $phone,
                'refer_code' => $this->generateReferralCode(),
            ]);
        }

        // Sanctum create token---
        $token = $user->createToken('auth_token')->plainTextToken;

        // OTP remove---
        $otpRecord->delete();

        return response()->json([
            'message' => 'OTP verified successfully. Please update your profile.',
            'status' => 'success',
            'token' => $token,
            'user' => $user,
        ]);
    }

    //--updateProfile
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|min:6',
            'confirmed_password' => 'required|min:6',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Match password and confirmed_password
        if ($request->password !== $request->confirmed_password) {
            return response()->json(['message' => 'Password and confirmed password do not match.']);
        }

        $auth = Auth::user();
        $user = User::find($auth->id);
        $user->name = $request->name;
        $user->refer = $request->refer;
        $user->password = Hash::make($request->password);
        $user->is_otp_verified = true;
        $user->is_login = true;
        $user->access_token = Str::random(20);

        // Handle profile image upload
        if ($request->hasFile('profile')) {
            // Delete the old profile image if it exists
            if ($user->profile && file_exists(public_path('profile/' . $user->profile))) {
                unlink(public_path('profile/' . $user->profile));
            }

            // Store the new profile image
            $image = $request->file('profile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile'), $imageName);
            $user->profile = $imageName;
        }

        if ($user->save()) {

            //-- create user total balance data
            TotalBalance::create([
                'user_id' => $user->id,
                'balance' => 0
            ]);

            //-- create user wining balance data
            WiningBalance::create([
                'user_id' => $user->id,
                'balance' => 0
            ]);

            //-- refer increment 
            if ($user->refer) {
                $referUser = User::where('refer_code', $user->refer)->first();
                if ($referUser) {
                    $referUser->increment('refer_count');
                    $referUser->increment('total_refer_count');
                }
            }

            return response()->json([
                'status' => 'success_update',
                'message' => 'Profile updated successfully.'
            ]);
        } else {
            return response()->json(
                [
                    'status' => 'failed_update',
                    'message' => 'Failed to update profile.'
                ]
            );
        }
    }



    //--login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $phone = str_replace('+88', '', $request->phone);

        // Find the user by phone number
        $user = User::where('phone', $phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid phone number or password.'], 401);
        }


        //-- check user block or not
        if ($user->is_block == 0) {
            return response()->json([
                'status' => 'blocked',
                'message' => 'Your account is blocked. Please contact support.'
            ], 401);
        }

        // If OTP was verified already, allow login with password
        if (!$user->is_otp_verified) {
            return response()->json(['message' => 'OTP not verified.'], 401);
        }



        //-- check user already login or not 
        if ($user->is_login) {
            return response()->json([
                'status' => 'already_logged_in',
                'message' => 'You are already logged in.'
            ], 401);
        }

        $user->update(['is_login' => true]);
        // Sanctum create token---
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Logged in successfully.',
            'status' => 'success',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'profile' => $user->profile ? asset('profile/' . $user->profile) : null,
                'refer_code' => $user->refer_code,
                'refer' => $user->refer,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]
        ]);
    }

    //--logout
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->update(['is_login' => false]);
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }


    ///-- ProfileChange
    public function profileChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $auth = Auth::user();
        $user = User::find($auth->id);
        $user->name = $request->name;

        // Handle profile image upload
        if ($request->hasFile('profile')) {
            // Delete the old profile image if it exists
            if ($user->profile && file_exists(public_path('profile/' . $user->profile))) {
                unlink(public_path('profile/' . $user->profile));
            }

            // Store the new profile image
            $image = $request->file('profile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile'), $imageName);
            $user->profile = $imageName;
        }

        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully.'
            ]);
        } else {
            return response()->json(
                [
                    'status' => 'failed_update',
                    'message' => 'Failed to update profile.'
                ]
            );
        }
    }


    //--generate reffer code --
    private function generateReferralCode()
    {
        do {
            //-- generate random number
            $code = rand(100000, 999999);
        } while (User::where('refer_code', $code)->exists());
        return $code;
    }
}
