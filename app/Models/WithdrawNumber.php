<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawNumber extends Model
{
    protected $guarded = [];
    //--relation user model 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //-- relation withdraw model
    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }
}
