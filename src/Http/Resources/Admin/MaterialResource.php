<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'amount'     => $this->amount ?? '',
            'discount'   => $this->discount ?? '',
            'details'    => $this->details ?? '',
            'items'      => $this->items->transform(fn ($i) => $i->details) ?? [],
            'num'        => $this->tutorials->count() ?? 0,
            'photo'      => $this->photos ? $this->photos->last() : null,
            'photo'      => $this->firstPhoto ?? null,
            // 'photos'     => $this->photos ?? null,
            'teacher'    => $this->teacher->name ?? '-',
            'access'     => $this->users->count(),
            'tutorials'  => $this->tutorials ? $this->tutorials->transform(fn ($e) => [
                'url' => $e->url,
                'title' => $e->title,
                'details' => $e->details ?? '',
            ]) : [],
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
