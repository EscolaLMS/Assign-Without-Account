<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Support\Facades\Gate;

class AccessUrlListRequest extends AccessUrlRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('list', AccessUrl::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
