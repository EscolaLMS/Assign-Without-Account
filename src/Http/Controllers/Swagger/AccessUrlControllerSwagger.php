<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger;

use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlCreateRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlDeleteRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlUpdateRequest;
use Illuminate\Http\JsonResponse;

interface AccessUrlControllerSwagger
{
    public function create(AccessUrlCreateRequest $request): JsonResponse;

    public function update(AccessUrlUpdateRequest $request, int $id): JsonResponse;

    public function delete(AccessUrlDeleteRequest $request, int $id): JsonResponse;

    public function index(AccessUrlListRequest $request): JsonResponse;
}
