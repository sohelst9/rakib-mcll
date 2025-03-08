<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [];

    public function category()
    {
      return $this->belongsTo(category::class, 'category_id');
    }
    
}
