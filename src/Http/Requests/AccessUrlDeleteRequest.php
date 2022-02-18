<?php

namespace EscolaLms\AssignWithoutAccount\Http\Requests;

class AccessUrlDeleteRequest extends AccessUrlRequest
{
    public function authorize(): bool
    {
        $accessUrl = $this->getAccessUrl();

        // TODO add permissions
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
