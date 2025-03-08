<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentGameScoreController extends Controller
{
    //--update_score
    public function update_score(Request $request)
    {
        info('Game Score Info: ', $request->all());
        $game_id = $request->input('game_id');
        $user_id = $request->input('user_id');
        $score = $request->input('score');
        
        
        return response()->json('Score Added');
    }
}
