<?php

use App\Http\Controllers\Admin\AllTransactionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BattleGameController;
use App\Http\Controllers\Admin\CashbackController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReferrController;
use App\Http\Controllers\Admin\ReturnDepositController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TournamentGameController;
use App\Http\Controllers\Admin\TournamentPaymentController;
use App\Http\Controllers\Admin\TournamentPlayersController;
use App\Http\Controllers\Admin\UserListController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\payment\UniquepayController;
use App\Http\Controllers\TournamentGameScoreController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/sms-send', function() {
    $phone = '01305191222';
    $message = 'Hello, This is a test message';
    $url = "http://sms.joypurhost.com/api/smsapi?api_key=lEHIet1hTPvMf94Bpwl2&type=text&number={$phone}&senderid=8809617624788&message={$message}";

    $response = Http::get($url);
    return $response->body();

});



Route::get('/bulk-sms', function () {
    

    $phone = "01775484658"; // Replace with recipient phone number
    $message = "Hello, this is a test SMS!"; // Replace with your message

    $api_key = "lEHIet1hTPvMf94Bpwl2"; // Replace with your actual API key
    $sender_id = "8809617624788"; // Your sender ID

    // Encode message to prevent URL issues
    $encoded_message = urlencode($message);

    // Construct API URL dynamically
    $url = "http://sms.joypurhost.com/api/smsapi?api_key=$api_key&type=text&number=$phone&senderid=$sender_id&message=$encoded_message";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    // Handle API response
    if ($http_code == 200) {
        echo "✅ SMS sent successfully: " . $response;
    } else {
        echo "❌ Failed to send SMS. HTTP Code: " . $http_code . " Response: " . $response;
    }

});



Route::get('/clear-all-cache', function() {
    Artisan::call('optimize:clear'); 
    return response()->json([
        'status' => 'success',
        'message' => 'All cache cleared successfully!'
    ]);
});

//--payment success and failed route---
Route::get('payment/success', function () {
    return view('payment.success');
})->name('payment.success');
Route::get('payment/cancel', function () {
    return view('payment.cancel');
})->name('payment.cancel');


Route::get('/game-access-denied', function () {
    return view('game_access_denied');
})->name('game-access-denied');

//-- payment with uniquepaybd---
Route::prefix('uniquepay/')->group(function () {
    Route::get('payment/create', [UniquepayController::class, 'payment'])->name('uniquepay.payment');
    Route::post('payment/create', [UniquepayController::class, 'payment_create'])->name('uniquepay.payment.create');
    Route::get('payment/success', [UniquepayController::class, 'payment_success'])->name('uniquepay.payment.success');
    Route::get('payment/cancel', [UniquepayController::class, 'payment_cancel'])->name('uniquepay.payment.cancel');
});



Route::get('tournament-game-score', [TournamentGameScoreController::class, 'update_score']);

//---dashbaord---
Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'store'])->name('admin.login.store');
Route::prefix('admin/')->middleware('admin.auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('logout', [DashboardController::class, 'logout'])->name('admin.logout');
    Route::get('profile', [ProfileController::class, 'profile'])->name('admin.profile');
    Route::post('profile/update', [ProfileController::class, 'profile_update'])->name('admin.profile.update');
    Route::post('password/update', [ProfileController::class, 'password_update'])->name('admin.password.update');


    //-- category---
    Route::resource('category', CategoryController::class);
    Route::resource('cashback', CashbackController::class);
    Route::get('cashback/status/{id}', [CashbackController::class, 'status'])->name('cashback.status');



    //-- games route ----
    Route::prefix('battle/')->as('admin.battle.')->group(function () {
        Route::get('games', [BattleGameController::class, 'index'])->name('games');
        Route::get('game', [BattleGameController::class, 'create'])->name('game.create');
        Route::post('game', [BattleGameController::class, 'store'])->name('game.store');
        Route::get('game/{slug}', [BattleGameController::class, 'edit'])->name('game.edit');
        Route::put('game/{slug}', [BattleGameController::class, 'update'])->name('game.update');
        Route::delete('game/{slug}', [BattleGameController::class, 'delete'])->name('game.delete');
    });

    Route::prefix('tournament/')->as('admin.tournament.')->group(function () {
        Route::get('games', [TournamentGameController::class, 'index'])->name('games');
        Route::get('game', [TournamentGameController::class, 'create'])->name('game.create');
        Route::post('game', [TournamentGameController::class, 'store'])->name('game.store');
        Route::get('game/{slug}', [TournamentGameController::class, 'edit'])->name('game.edit');
        Route::put('game/{slug}', [TournamentGameController::class, 'update'])->name('game.update');
        Route::delete('game/{slug}', [TournamentGameController::class, 'delete'])->name('game.delete');
        Route::get('game/price/{slug}', [TournamentGameController::class, 'prices'])->name('game.price');
        Route::post('game/price/{slug}', [TournamentGameController::class, 'price_store'])->name('game.price.store');
        Route::get('game/price/status/{slug}', [TournamentGameController::class, 'price_status'])->name('game.price.status');
        Route::get('game/price/edit/{slug}', [TournamentGameController::class, 'price_edit'])->name('game.price.edit');
        Route::put('game/price/update/{slug}', [TournamentGameController::class, 'price_update'])->name('game.price.update');
        Route::delete('game/price/delete/{slug}', [TournamentGameController::class, 'price_delete'])->name('game.price.delete');
        Route::get('game/players/{slug}', [TournamentPlayersController::class, 'game_players'])->name('game.players');
        Route::get('game/leaderboard/{slug}', [TournamentPlayersController::class, 'game_leaderboard'])->name('game.leaderboard');
        Route::get('payment/{slug}', [TournamentPaymentController::class, 'tournament_payment'])->name('payment');
        Route::post('payment/store', [TournamentPaymentController::class, 'tournament_payment_store'])->name('tournament_payment_store');
        Route::get('get_user_withdraw_number/{user_id}', [TournamentPaymentController::class, 'get_user_withdraw_number'])->name('get_user_withdraw_number');
        Route::get('wining/payment/list', [TournamentPaymentController::class, 'twining_payment_list'])->name('winingpayment_list');

        //--status--
        Route::get('game/status/{slug}', [TournamentGameController::class, 'status'])->name('game.status');
    });

    //-- get datas
    Route::get('transactions', [AllTransactionController::class, 'alltrnx'])->name('admin.alltrnx');
    Route::get('all-user', [UserListController::class, 'userlists'])->name('admin.userlists');
    Route::delete('user/delete/{id}', [UserListController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::get('user/block/{id}', [UserListController::class, 'blockUser'])->name('admin.user.block');

    //-- cash deposit
    Route::get('deposits', [DepositController::class, 'index'])->name('admin.deposits');
    Route::get('deposit/payment/status/{addcash}', [DepositController::class, 'payment_status'])->name('admin.deposit.payment_status');

    //-- add cash 
    Route::get('add-cash', [DepositController::class, 'add_cash'])->name('admin.add.cash');
    Route::post('add-cash', [DepositController::class, 'add_cash_update'])->name('admin.add.cash.update');

    //--- return deposit
    Route::get('return-cash', [ReturnDepositController::class, 'return_cash'])->name('admin.cash.return');
    Route::post('return-cash', [ReturnDepositController::class, 'return_cash_store'])->name('admin.cash.return.store');
    Route::get('return-cash/edit/{id}', [ReturnDepositController::class, 'return_cash_edit'])->name('admin.cash.return.edit');
    Route::post('return-cash/update/{id}', [ReturnDepositController::class, 'return_cash_update'])->name('admin.cash.return.update');

    //-- withdraw---
    Route::get('withdraws', [WithdrawController::class, 'index'])->name('admin.withdraws');
    Route::post('withdraw/update/{id}', [WithdrawController::class, 'updateTrnxId'])->name('withdraw.updateTrnxId');
    Route::get('withdraw/status/{id}', [WithdrawController::class, 'withdraw_status'])->name('admin.withdraw.status');
    Route::get('withdraws-number', [WithdrawController::class, 'withdraws_number'])->name('admin.withdraws.number');
    Route::get('withdraws-number/edit/{id}', [WithdrawController::class, 'withdraws_number_edit'])->name('admin.withdraws.number.edit');
    Route::put('withdraws-number/update/{id}', [WithdrawController::class, 'withdraws_number_update'])->name('admin.withdraws.number.update');
    Route::delete('withdraws-number/delete/{id}', [WithdrawController::class, 'withdraws_number_delete'])->name('admin.withdraws.number.delete');

    //--setting --
    Route::get('setting', [SettingController::class, 'index'])->name('admin.setting');
    Route::post('setting/{id}', [SettingController::class, 'update_setting'])->name('admin.setting.update');

    //--banner ---
    Route::get('banner', [BannerController::class, 'index'])->name('banner.index');
    Route::post('banner/{id}', [BannerController::class, 'update'])->name('banner.update');

    //-- refer ---
    Route::get('refer/lists', [ReferrController::class, 'refer_list'])->name('admin.refer');
    Route::get('refer/clear', [ReferrController::class, 'refer_clear'])->name('admin.refer.clear');
});
