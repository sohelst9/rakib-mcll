<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function withdraw_number()
    {
        return $this->hasOne(WithdrawNumber::class, 'number', 'withdraw_number_id');
    }
}
