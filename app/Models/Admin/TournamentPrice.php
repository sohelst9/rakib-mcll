<?php

namespace App\Models\Admin;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Model;

class TournamentPrice extends Model
{
    protected $guarded = [];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
