<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsResource extends JsonResource
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
            'title' => $this->title,
            'trnx_type' => $this->trnx_type,
            'amount' => $this->amount,
            'trnx_id' => $this->trnx_id,
            'status' => $this->status == 1 ? 'COMPLETE' : 'PENDING',
            'trnx_date' => $this->trnx_date,
        ];
    }
}
