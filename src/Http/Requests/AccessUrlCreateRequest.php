<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AccessUrlCreateRequest extends AccessUrlRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', AccessUrl::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'url' => [
                'required',
                'string',
                Rule::unique(AccessUrl::class, 'url')
            ],
            'modelable_id' => [
                'required',
                'integer',
                Rule::unique(AccessUrl::class)->where(function ($query) {
                    $query->where('modelable_id', $this->modelable_id)
                        ->where('modelable_type', $this->modelable_type);
                }),
            ],
            'modelable_type' => [
                'required',
                'string',
            ],
        ];
    }
}
