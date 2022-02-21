<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger;

use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionCreateRequest;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Http\JsonResponse;

interface UserSubmissionControllerSwagger
{
    public function create(AccessUrl $accessUrl, UserSubmissionCreateRequest $request): JsonResponse;
}
