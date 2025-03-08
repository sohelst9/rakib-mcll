<?php

namespace App\Models;

use App\Models\Admin\TournamentPrice;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function tournament_prices()
    {
        return $this->hasmany(TournamentPrice::class);
    }

    //-- relation with Tournament Score
    public function tournament_scores()
    {
        return $this->hasMany(TournamentScore::class);
    }

    //-- raltion tournament payment details
    public function tournament_payment_details()
    {
        return $this->hasMany(TournamentPaymentDetails::class);
    }

    //-- relation tournament wining payment details
    public function tournament_winning_payment_details()
    {
        return $this->hasMany(TournamentWiningPaymentDetails::class);
    }
}
