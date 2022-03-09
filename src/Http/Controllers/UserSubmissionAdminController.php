<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers;

use EscolaLms\AssignWithoutAccount\Dto\UserSubmissionDto;
use EscolaLms\AssignWithoutAccount\Dto\UserSubmissionSearchDto;
use EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger\UserSubmissionAdminControllerSwagger;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionCreateRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionListRequest;
use EscolaLms\AssignWithoutAccount\Http\Resources\UserSubmissionResource;
use EscolaLms\AssignWithoutAccount\Services\Contracts\UserSubmissionServiceContract;
use EscolaLms\Core\Dtos\PaginationDto;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use Illuminate\Http\JsonResponse;

class UserSubmissionAdminController extends EscolaLmsBaseController implements UserSubmissionAdminControllerSwagger
{
    private UserSubmissionServiceContract $userSubmissionService;

    public function __construct(UserSubmissionServiceContract $userSubmissionService)
    {
        $this->userSubmissionService = $userSubmissionService;
    }

    public function index(UserSubmissionListRequest $request): JsonResponse
    {
        $result = $this->userSubmissionService->searchAndPaginate(
            UserSubmissionSearchDto::instantiateFromRequest($request),
            PaginationDto::instantiateFromRequest($request),
        );

        return $this->sendResponseForResource(UserSubmissionResource::collection($result), "User submissions retrieved successfully");
    }

    public function create(UserSubmissionCreateRequest $request): JsonResponse
    {
        $dto = UserSubmissionDto::instantiateFromRequest($request);
        $result = $this->userSubmissionService->create($dto);
        return $this->sendResponseForResource(UserSubmissionResource::make($result), "User submissions created successfully");
    }
}
