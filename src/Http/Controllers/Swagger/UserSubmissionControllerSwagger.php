<?php

namespace EscolaLms\AssignWithoutAccount\Http\Controllers\Swagger;

use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionListRequest;
use EscolaLms\AssignWithoutAccount\Http\Requests\UserSubmissionCreateRequest;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Http\JsonResponse;

interface UserSubmissionControllerSwagger
{
    /**
     * @OA\Post (
     *     path="/api/user-submissions/{access-url}",
     *     summary="Create a new user submission",
     *     tags={"Assign Without Account"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="email",
     *                 description="User email",
     *                 type="string",
     *             ),
     *             @OA\Property(
     *                 property="frontend_url",
     *                 description="Frontend url to course, webinar etc.",
     *                 type="string",
     *             ),
     *         )
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
     *          response=500,
     *          description="Server-side error",
     *      ),
     * )
     *
     * @param AccessUrl $accessUrl
     * @param UserSubmissionCreateRequest $request
     * @return JsonResponse
     */
    public function create(AccessUrl $accessUrl, UserSubmissionCreateRequest $request): JsonResponse;
}
