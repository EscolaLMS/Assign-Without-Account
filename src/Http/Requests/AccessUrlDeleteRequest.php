<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use Illuminate\Support\Facades\Gate;

class AccessUrlDeleteRequest extends AccessUrlRequest
{
    public function authorize(): bool
    {
        $accessUrl = $this->getAccessUrl();
        return Gate::allows('delete', $accessUrl);
    }

    public function rules(): array
    {
        return [];
    }
}
