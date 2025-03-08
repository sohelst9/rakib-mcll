<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TournamentScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TournamentScoreController extends Controller
{
    //--get_score
    public function get_score(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'game_id' => 'required',
            'user_id' => 'required',
            'score' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user_id = $request->input('user_id');
        $tournament_id = $request->input('game_id');
        $score = intval($request->input('score'));
        info('Tournament Score : ', ['score' => $score]);

        $same_user = TournamentScore::where('user_id', $user_id)
            ->where('tournament_id', $tournament_id)
            ->first();

        if ($same_user) {
            if ($same_user->score < $score) {
                $same_user->score = $score;
                $same_user->save();
            }
        } else {
            TournamentScore::create([
                'user_id' => $user_id,
                'tournament_id' => $tournament_id,
                'score' => $score
            ]);
        }

        return response()->json(['message' => 'Score updated or Create successfully'], 200);
    }
}
