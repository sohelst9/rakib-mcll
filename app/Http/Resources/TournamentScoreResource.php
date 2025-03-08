<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentScoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user_id ? $this->user->name : null,
            'user_profile' => $this->user_id && $this->user->profile ? asset('profile/' .$this->user->profile) : null,
            'game_name' => $this->tournament_id ? $this->tournament->name : null,
            'rank' => $this->rank,
            'score' => $this->score,
        ];
    }
}
