<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSubmissionListRequest extends FormRequest
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
