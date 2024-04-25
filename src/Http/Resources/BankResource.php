<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name ?? '',
            'details'       => $this->details ?? '',
            'toggle'        => $this->status,
            'amount'        => $this->amount,
            'amount_in'     => $this->amount_in ?? '',
            'amount_out'    => $this->amount_out ?? '',
            'dollar'        => $this->dollar ?? '',
            // 'num'           => $this->budget->count() ?? 0,
            'created_at'    => $this->created_at ? $this->created_at->format('d-m-Y :h:i:s') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
