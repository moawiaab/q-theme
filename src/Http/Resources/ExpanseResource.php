<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpanseResource extends JsonResource
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
            'name'          => $this->budgetName->name ?? '',
            'amount'        => $this->amount ?? 0,
            'text_amount'   => $this->text_amount ?? 'لا يوجد نص',
            'beneficiary'   => $this->beneficiary,
            'details'       => $this->details,
            'stage'         => $this->stage,
            'user'          => $this->user->name ?? '',
            'user_id'       => $this->user_id ?? '',
            'created_at'    => $this->created_at ? $this->created_at->diffForHumans() : '',
            'deleted_at'    => $this->deleted_at ?? '',
        ];
    }
}
