<?php

namespace Moawiaab\QTheme\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TutorialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title ?? '',
            'details'    => $this->details ?? '',
            'url'        => $this->url ?? '',
            'teacher'    =>  $this->teacher->name ?? '',
            'user'       => $this->user->name ?? '',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : '',
            'deleted_at' => $this->deleted_at ?? '',
        ];
    }
}
