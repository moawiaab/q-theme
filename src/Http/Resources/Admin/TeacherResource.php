<?php

namespace Moawiaab\QTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'address'    => $this->address ?? '',
            'email'      => $this->user->email ?? 'ليس لده اسم دخول',
            'details'    => $this->details ?? '',
            // 'level'      => $this->levels->count() ?? 0,
            // 'material'   => $this->materials->count() ?? 0,
            // 'materials'  => $this->materials->transform(fn ($e) => [
            //     'name' => $e->name,
            //     'details' => $e->name,
            //     'max_degree' => $e->max_degree,
            //     'min_degree' => $e->min_degree,
            //     'level' => $e->levels->transform(fn ($i) => $i->name) ?? []
            // ]) ?? [],
            'phone'      => $this->phone ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
