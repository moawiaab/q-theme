<?php

namespace Moawiaab\QTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDataResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? 'no data',
            'email'      => $this->email ?? 'no data',
            'phone'      => $this->phone ?? '00000000',
            'role'       => $this->role->title ?? 'no data',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : 'no data',
        ];
    }
}
