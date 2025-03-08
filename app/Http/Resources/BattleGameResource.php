<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BattleGameResource extends JsonResource
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
            'game_file' => asset($this->file),
            'game_link' => $this->game_link,
            'thumbnail' => asset($this->thumbnail),
            'description' => strip_tags($this->description),
            'short_desc' => Str::words(strip_tags($this->description), 20, '...'),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at,
        ];
    }
}
