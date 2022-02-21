<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AccessUrlUpdateRequest extends AccessUrlRequest
{
    public function authorize(): bool
    {
        $accessUrl = $this->getAccessUrl();
        return Gate::allows('update', $accessUrl);
    }

    public function rules(): array
    {
        return [
            'url' => ['required', 'string', Rule::unique(AccessUrl::class, 'url')],
        ];
    }
}
