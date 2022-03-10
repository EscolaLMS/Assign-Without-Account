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

    /**
     * @OA\Post(
     *     path="/api/admin/user-submissions",
     *     summary="Create a new user submission identified by id",
     *     tags={"Assign Without Account"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\RequestBody(
     *         description="User submission attributes",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserSubmission")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="User submission created successfully",
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Endpoint requires authentication",
     *      ),
     *     @OA\Response(
     *          response=403,
     *          description="User doesn't have required access rights",
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="One of the parameters has invalid format",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Server-side error",
     *      ),
     * )
     *
     * @param UserSubmissionCreateRequest $request
     * @return JsonResponse
     */
    public function create(UserSubmissionCreateRequest $request): JsonResponse;
}
