<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use Illuminate\Support\Facades\Gate;

class UserSubmissionRejectRequest extends UserSubmissionRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $userSubmission = $this->getUserSubmission();
        return Gate::allows('reject', $userSubmission);
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
