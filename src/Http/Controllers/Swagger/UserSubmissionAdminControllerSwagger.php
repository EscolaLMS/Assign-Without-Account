<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger;

use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionAcceptRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionRejectRequest;
use Illuminate\Http\JsonResponse;

interface UserSubmissionAdminControllerSwagger
{
    /**
     * @OA\GET(
     *     path="/api/admin/user-submissions/accpet/{id}",
     *     summary="Accept user submission identified by a id",
     *     tags={"Assign Without Account"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(
     *         description="Unique human-readable user submission identifier",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="User submission accepted successfully",
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
     *          response=500,
     *          description="Server-side error",
     *      ),
     * )
     *
     * @param UserSubmissionAcceptRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function accept(UserSubmissionAcceptRequest $request, int $id): JsonResponse;

    /**
     * @OA\GET(
     *     path="/api/admin/user-submissions/reject/{id}",
     *     summary="Reject user submission identified by a id",
     *     tags={"Assign Without Account"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(
     *         description="Unique human-readable user submission identifier",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="User submission rejected successfully",
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
     *          response=500,
     *          description="Server-side error",
     *      ),
     * )
     *
     * @param UserSubmissionRejectRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function reject(UserSubmissionRejectRequest $request, int $id): JsonResponse;

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
}
