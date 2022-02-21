<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

abstract class UserSubmissionRequest extends FormRequest
{
    public function getUserSubmission(): UserSubmission
    {
        return UserSubmission::findOrFail($this->route('id'));
    }
}
