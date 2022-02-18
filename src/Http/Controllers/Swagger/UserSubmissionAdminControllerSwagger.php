<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger;

use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionUpdateRequest;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Http\JsonResponse;

interface UserSubmissionAdminControllerSwagger
{
    public function accept(UserSubmissionUpdateRequest $request, int $id): JsonResponse;

    public function reject(UserSubmissionUpdateRequest $request, int $id): JsonResponse;

    public function index(UserSubmissionListRequest $request): JsonResponse;
}
