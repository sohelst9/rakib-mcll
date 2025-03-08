<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentPaymentDetails;
use App\Models\TournamentScore;
use Illuminate\Http\Request;

class TournamentPlayersController extends Controller
{
    //--game_players
    public function game_players($slug)
    {
        $tGame = Tournament::where('slug', $slug)->first();
        $details = TournamentPaymentDetails::where('tournament_id', $tGame->id)->with('user', 'tournament')->get();
        return view('Admin.game.tournamentGame.players.index', [
            'details' => $details
        ]);
    }

    //--game_leaderboard
    public function game_leaderboard($slug)
    {
        $tGame = Tournament::where('slug', $slug)->first();
        $tournamentScores = TournamentScore::where('tournament_id', $tGame->id)
            ->join('users', 'tournament_scores.user_id', '=', 'users.id')
            ->join('tournaments', 'tournament_scores.tournament_id', '=', 'tournaments.id')
            ->select('tournament_scores.user_id', 'users.name as user_name', 'tournaments.name as tournament_name', 'tournament_scores.score')
            ->orderByDesc('tournament_scores.score')
            ->get();

        return view('Admin.game.tournamentGame.leaderboard.index', [
            'tournamentScores' => $tournamentScores
        ]);
    }
}
