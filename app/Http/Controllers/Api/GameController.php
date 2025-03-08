<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BattleGameResource;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    //--ballteGames
    public function ballteGames(Request $request)
    {
        $games = Game::all();
        return BattleGameResource::collection($games);
    }

    
}
