<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TournamentGameResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'category_id' => $this->category_id ? $this->category->name : 'null',
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'entry_fee' => $this->entry_fee,
            'game_link' => asset($this->file),
            'thumbnail' => asset($this->thumbnail),
            'description' => strip_tags($this->description),
            'short_desc' => Str::words(strip_tags($this->description), 20, '...'),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at,
            'total_join' => $this->tournament_payment_details_count,
            'total_price' => $this->tournament_prices_sum_price,
        ];
    }
}
