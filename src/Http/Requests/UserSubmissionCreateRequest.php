<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSubmissionCreateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns', 'string'],
            'frontend_url' => ['required', 'string'],
        ];
    }
}
