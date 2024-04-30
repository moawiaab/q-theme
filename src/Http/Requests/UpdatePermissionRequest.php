<?php

namespace Moawiaab\QTheme\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate as FacadesGate;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return FacadesGate::allows('permission_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'details' => [
                'string',
                'required',
            ],
        ];
    }
}
