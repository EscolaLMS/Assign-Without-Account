<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger;

use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlCreateRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlDeleteRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\AccessUrlUpdateRequest;
use Illuminate\Http\JsonResponse;

interface AccessUrlControllerSwagger
{
    /**
     * @OA\Post(
     *     path="/api/admin/access-url",
     *     summary="Create a new access url identified by id",
     *     tags={"Assign Without Account"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\RequestBody(
     *         description="Access url attributes",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AccessUrl")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="access url created successfully",
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="endpoint requires authentication",
     *      ),
     *     @OA\Response(
     *          response=403,
     *          description="user doesn't have required access rights",
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="one of the parameters has invalid format",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="server-side error",
     *      ),
     * )
     *
     * @param AccessUrlCreateRequest $request
     * @return JsonResponse
     */
    public function create(AccessUrlCreateRequest $request): JsonResponse;

    /**
     * @OA\Patch (
     *     path="/api/admin/access-url/{id}",
     *     summary="Update an existing access url identified by id",
     *     tags={"Assign Without Account"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(
     *         description="Unique human-readable access url identifier",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Access url attributes",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AccessUrl")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="access url created successfully",
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="endpoint requires authentication",
     *      ),
     *     @OA\Response(
     *          response=403,
     *          description="user doesn't have required access rights",
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="one of the parameters has invalid format",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="server-side error",
     *      ),
     * )
     *
     * @param AccessUrlUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AccessUrlUpdateRequest $request, int $id): JsonResponse;

    /**
     * @OA\Delete(
     *     path="/api/admin/access-url/{id}",
     *     summary="Delete access url identified by a id",
     *     tags={"Assign Without Account"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(
     *         description="Unique human-readable access url identifier",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="access url deleted successfully",
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="endpoint requires authentication",
     *      ),
     *     @OA\Response(
     *          response=403,
     *          description="user doesn't have required access rights",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="server-side error",
     *      ),
     * )
     *
     * @param AccessUrlDeleteRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function delete(AccessUrlDeleteRequest $request, int $id): JsonResponse;

    /**
     * @OA\Get(
     *     path="/api/admin/access-url",
     *     summary="Lists available access urls",
     *     tags={"Assign Without Account"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(
     *         description="Id of Model (Course, Webinar etd.)",
     *         in="query",
     *         name="modelable_id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Name of Model (Course, Webinar etd.)",
     *         in="query",
     *         name="modelable_type",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="list of available access urls",
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="endpoint requires authentication",
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="user doesn't have required access rights",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="server-side error",
     *      ),
     * )
     *
     * @param AccessUrlListRequest $request
     * @return JsonResponse
     */
    public function index(AccessUrlListRequest $request): JsonResponse;
}
