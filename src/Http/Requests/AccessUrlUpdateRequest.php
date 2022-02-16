<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccessUrlUpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge(['id' => $this->route('id')]);
    }

    public function authorize(): bool
    {
        // TODO add permissions
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', Rule::exists(AccessUrl::class, 'id')],
            'url' => ['required', 'string', Rule::unique(AccessUrl::class, 'url')],
        ];
    }
}
