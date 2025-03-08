<?php

use App\Http\Controllers\Api\AddCashController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BattleGameController;
use App\Http\Controllers\Api\CashbackController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\TournamentController;
use App\Http\Controllers\Api\TournamentScoreController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserManageController;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\payment\UniquepayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserManageController::class, 'user']);
    Route::post('/update-profile', [AuthenticationController::class, 'updateProfile']);
    Route::post('/profile-change', [AuthenticationController::class, 'ProfileChange']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    //-- battle games
     Route::middleware(['cache'])->get('/battle/games', [GameController::class, 'ballteGames']);

    //-- tournament games
    Route::prefix('tournament/')->group(function () {
        Route::get('games', [TournamentController::class, 'tournamentGames']);
        Route::get('game/{tournament:slug}', [TournamentController::class, 'tournamentsingleGame']);
        Route::get('prices/{slug}', [TournamentController::class, 'tournamentPrices']);
        Route::post('payment', [TournamentController::class, 'tournamentPayment']);
        Route::get('check-payment/{slug}', [TournamentController::class, 'checkPayment']);

        //-- leaderboard--
        Route::get('leaderboard', [LeaderboardController::class, 'index']);
    });

    //--battle games---
    Route::prefix('battle/')->group(function () {
        
    });

    Route::get('transactions', [TransactionController::class, 'transactions']);

    //--- user balance
    Route::get('/total-balance', [UserManageController::class, 'totalbalance']);
    Route::get('/user-wallet', [UserManageController::class, 'user_wallet']);

    //-- add cash or deposit and cashback
    Route::get('cashback', [CashbackController::class, 'cashback']);
    Route::post('/get-cashback-message', [AddCashController::class, 'getCashbackMessage']);
    Route::post('/add-cash', [AddCashController::class, 'addCash']);

    //-- withdraw --
    Route::post('/withdraw-request', [WithdrawController::class, 'withdrawRequest']);
    Route::post('/withdraw-number-save', [WithdrawController::class, 'withdrawNumberSave']);
    Route::get('/withdraw-number-get', [WithdrawController::class, 'withdrawNumberGet']);
    Route::get('/withdraw-history', [WithdrawController::class, 'withdrawUserTrnx']);

    //-- setting --
    Route::get('/setting', [SettingController::class, 'setting']);
    Route::get('/banner', [BannerController::class, 'banner']);
    Route::get('/refer/list', [UserManageController::class, 'refer_list']);
});

Route::post('/send-otp', [AuthenticationController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthenticationController::class, 'verifyOtp']);
Route::post('/login', [AuthenticationController::class, 'login']);

//-- password reset
Route::post('/password/forgot', [PasswordResetController::class, 'forgot_sendOtp']);
Route::post('/password/verify-otp', [PasswordResetController::class, 'forgot_verifyOtp']);
Route::post('/password/reset', [PasswordResetController::class, 'forgot_resetPassword']);

//-- score --
Route::get('tournament/score', [TournamentScoreController::class, 'get_score']);


Route::post('battle/get_user', [BattleGameController::class, 'get_user']);
Route::post('battle/update_user', [BattleGameController::class, 'update_user']);


