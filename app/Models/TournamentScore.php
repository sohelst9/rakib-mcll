<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentScore extends Model
{
    protected $guarded = [];

    //--- relation user model ----
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //-- relation tournament model ----
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

}
