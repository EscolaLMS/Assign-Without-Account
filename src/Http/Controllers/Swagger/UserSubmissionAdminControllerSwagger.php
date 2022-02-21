<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger;

use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionAcceptRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionRejectRequest;
use Illuminate\Http\JsonResponse;

interface UserSubmissionAdminControllerSwagger
{
    public function accept(UserSubmissionAcceptRequest $request, int $id): JsonResponse;

    public function reject(UserSubmissionRejectRequest $request, int $id): JsonResponse;

    public function index(UserSubmissionListRequest $request): JsonResponse;
}
