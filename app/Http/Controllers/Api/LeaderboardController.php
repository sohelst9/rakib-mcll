<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TournamentScoreResource;
use App\Models\TournamentScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaderboardController extends Controller
{
    //--index
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'tournament_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $user_id = $request->user_id;
        $tournament_id = $request->tournament_id;
        $alluserScore = TournamentScore::where('tournament_id', $tournament_id)
            ->orderByDesc('score')
            ->get();

        if ($alluserScore->count() > 0) {
            //-- add rank to each user
            $rankUsers = $alluserScore->values()
                ->map(function ($user, $index) {
                    $user->rank = $index + 1;
                    return $user;
                });

            $myScore = $rankUsers->firstWhere('user_id', $user_id);
            $myrank = $myScore ? $myScore->rank : null;
            return response()->json([
                'all_scores' => TournamentScoreResource::collection($rankUsers),
                'my_score' => $myScore ? new TournamentScoreResource($myScore) : null,
            ]);
        } else {
            return response()->json(['error' => 'No scores found'], 404);
        }
    }
}
