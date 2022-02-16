<?php

namespace EscolaLms\AssignWithoutAccount\Services;

use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionEnum;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\AssignWithoutAccount\Repositories\Contracts\UserSubmissionRepositoryContract;
use EscolaLms\AssignWithoutAccount\Services\Contracts\UserSubmissionServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserSubmissionService implements UserSubmissionServiceContract
{
    private UserSubmissionRepositoryContract $userSubmissionRepository;

    public function __construct(
        UserSubmissionRepositoryContract $userSubmissionRepository
    ) {
        $this->userSubmissionRepository = $userSubmissionRepository;
    }

    public function create(AccessUrl $accessUrl, array $data): UserSubmission
    {
        // TODO check user with email exists
        $submission = [
            'access_url_id' => $accessUrl->getKey(),
            'email' => $data['email'],
            'status' => UserSubmissionEnum::EXPECTED
        ];

        return $this->userSubmissionRepository->create($submission);
    }

    public function accept(int $id): UserSubmission
    {
        // TODO accept submission and send notification to user
    }

    public function reject(int $id): UserSubmission
    {
        // TODO update submission status
    }

    public function search(array $search = []): LengthAwarePaginator
    {
        return $this->userSubmissionRepository->searchAndPaginate($search);
    }
}
