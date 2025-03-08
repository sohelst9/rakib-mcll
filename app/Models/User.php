<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function totalbalance()
    {
        return $this->hasOne(TotalBalance::class, 'user_id', 'id');
    }

    public function winingbalance()
    {
        return $this->hasOne(WiningBalance::class, 'user_id', 'id');
    }

    public function add_cash()
    {
        return $this->hasMany(AddCash::class);
    }

    //-- relation tournament score model
    public function tournament_score()
    {
        return $this->hasMany(TournamentScore::class);
    }

    //-- relation tournament payment details 
    public function tournament_payment_details()
    {
        return $this->hasMany(TournamentPaymentDetails::class);
    }

    //-- tournament wining payment details-
    public function tournament_wining_payment_details()
    {
        return $this->hasMany(TournamentWiningPaymentDetails::class);
    }

    //-- relation withdraw model
    public function withdraw()
    {
        return $this->hasMany(Withdraw::class);
    }

    //-- relation withdraw number model
    public function withdraw_number()
    {
        return $this->hasOne(WithdrawNumber::class);
    }

    //--ReturnDeposit model relation
    public function return_deposit()
    {
        return $this->hasMany(ReturnDeposit::class);
    }

    //-- self  relation
    public function referrals()
    {
        return $this->hasMany(User::class, 'refer', 'refer_code');
    }
}
