<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger;

use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionCreateRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionListRequest;
use Illuminate\Http\JsonResponse;

interface UserSubmissionAdminControllerSwagger
{
    /**
     * @OA\Get(
     *     path="/api/admin/user-submissions",
     *     summary="Lists available user submissions",
     *     tags={"Assign Without Account"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(
     *         description="User email",
     *         in="query",
     *         name="email",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="User submission status",
     *         in="query",
     *         name="status",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of available user submissions",
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Endpoint requires authentication",
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="User doesn't have required access rights",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Server-side error",
     *      ),
     * )
     *
     * @param UserSubmissionListRequest $request
     * @return JsonResponse
     */
    public function index(UserSubmissionListRequest $request): JsonResponse;

    // TODO swagger
    public function create(UserSubmissionCreateRequest $request): JsonResponse;
}
