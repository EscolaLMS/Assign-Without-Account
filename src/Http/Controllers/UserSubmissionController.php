<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers;

use EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger\UserSubmissionControllerSwagger;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionCreateRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionUpdateRequest;
use EscolaLms\AssignWithoutAccount\Http\Resources\UserSubmissionResource;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Services\Contracts\UserSubmissionServiceContract;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use Illuminate\Http\JsonResponse;

/**
 * TODO add swagger
 */
class UserSubmissionController extends EscolaLmsBaseController implements UserSubmissionControllerSwagger
{
    private UserSubmissionServiceContract $userSubmissionService;

    public function __construct(UserSubmissionServiceContract $userSubmissionService)
    {
        $this->userSubmissionService = $userSubmissionService;
    }

    public function create(AccessUrl $accessUrl, UserSubmissionCreateRequest $request): JsonResponse
    {
        $this->userSubmissionService->create($accessUrl, $request->only(['email', 'frontend_url']));
        return $this->sendSuccess(__('User submissions successfully sent'));
    }
}
