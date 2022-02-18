<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Foundation\Http\FormRequest;

abstract class AccessUrlRequest extends FormRequest
{
    public function getAccessUrl(): AccessUrl
    {
        return AccessUrl::findOrFail($this->route('id'));
    }
}
