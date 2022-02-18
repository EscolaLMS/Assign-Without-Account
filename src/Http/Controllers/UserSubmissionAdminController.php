<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers;

use EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger\UserSubmissionAdminControllerSwagger;
use EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger\UserSubmissionControllerSwagger;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionUpdateRequest;
use EscolaLms\AssignWithoutAccount\Http\Resources\UserSubmissionResource;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Services\Contracts\UserSubmissionServiceContract;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use Illuminate\Http\JsonResponse;

/**
 * TODO add swagger
 */
class UserSubmissionAdminController extends EscolaLmsBaseController implements UserSubmissionAdminControllerSwagger
{
    private UserSubmissionServiceContract $userSubmissionService;

    public function __construct(UserSubmissionServiceContract $userSubmissionService)
    {
        $this->userSubmissionService = $userSubmissionService;
    }

    public function accept(UserSubmissionUpdateRequest $request, int $id): JsonResponse
    {
        $this->userSubmissionService->accept($id);

        return $this->sendSuccess(__('User submissions successfully accepted'));
    }

    public function reject(UserSubmissionUpdateRequest $request, int $id): JsonResponse
    {
        $this->userSubmissionService->reject($id);

        return $this->sendSuccess(__('User submissions successfully rejected'));
    }

    public function index(UserSubmissionListRequest $request): JsonResponse
    {
        $search = $request->only(['email', 'status']);
        $result = $this->userSubmissionService->search($search);

        return $this->sendResponseForResource(UserSubmissionResource::collection($result), "User submissions retrieved successfully");
    }
}
