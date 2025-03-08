<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentWiningPaymentDetails extends Model
{
    protected $guarded = [];

    //-- relation with user model--
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //-- relation with Tournament table--
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
