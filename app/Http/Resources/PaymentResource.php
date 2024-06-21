<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'transaction_id' => $this->transaction_id,
            'date'           => $this->date,
            'total_amount'   => $this->total_amount,
            'narration'      => $this->narration,
            'details'        => $this->details,
            'status'         => $this->status,
            'created_at'     => $this->created_at->format('d/m/Y'),
            'updated_at'     => $this->updated_at->format('d/m/Y'),
        ];
    }
}
