<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

class AccessUrlListRequest extends AccessUrlRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        // TODO add permissions
        return true;
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
