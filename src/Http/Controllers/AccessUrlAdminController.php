<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers;

use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlDeleteRequest;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger\AccessUrlControllerSwagger;
use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlCreateRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlUpdateRequest;
use EscolaLms\AssignWithoutAccount\Http\Resources\AccessUrlResource;
use EscolaLms\AssignWithoutAccount\Repositories\Contracts\AccessUrlRepositoryContract;
use Illuminate\Http\JsonResponse;

/**
 * TODO add swagger
 */
class AccessUrlAdminController extends EscolaLmsBaseController implements AccessUrlControllerSwagger
{
    private AccessUrlRepositoryContract $accessUrlRepository;

    public function __construct(AccessUrlRepositoryContract $accessUrlRepository)
    {
        $this->accessUrlRepository = $accessUrlRepository;
    }

    public function create(AccessUrlCreateRequest $request): JsonResponse
    {
        $accessUrl = $this->accessUrlRepository->create($request->only(['modelable_id', 'modelable_type', 'url']));

        return $this->sendResponseForResource(AccessUrlResource::make($accessUrl), __('Access url created successfully'));
    }

    public function update(AccessUrlUpdateRequest $request, int $id): JsonResponse
    {
        $accessUrl = $this->accessUrlRepository->update($request->only(['url']), $id);

        return $this->sendResponseForResource(AccessUrlResource::make($accessUrl), __('Access url updated successfully'));
    }

    public function delete(AccessUrlDeleteRequest $request, int $id): JsonResponse
    {
        $this->accessUrlRepository->delete($id);

        return $this->sendSuccess(__('Access url deleted successfully'));
    }

    public function index(AccessUrlListRequest $request): JsonResponse
    {
        $search = $request->only(['modelable_id', 'modelable_type']);
        $list = $this->accessUrlRepository->search($search);

        return $this->sendResponseForResource(AccessUrlResource::collection($list), __('Access urls retrieved successfully'));
    }
}
