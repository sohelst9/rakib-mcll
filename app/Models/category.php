<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $guarded = [];

    public function game()
    {
        return $this->hasMany(Game::class);
    }

    public function tournament()
    {
        return $this->hasMany(Tournament::class);
    }
}
