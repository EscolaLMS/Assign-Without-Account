<?php

namespace EscolaLms\AssignWithoutAccount\Services;

use EscolaLms\AssignWithoutAccount\Enums\UserSubmissionEnum;
use EscolaLms\AssignWithoutAccount\Events\UserSubmissionAccepted;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\AssignWithoutAccount\Repositories\Contracts\UserSubmissionRepositoryContract;
use EscolaLms\AssignWithoutAccount\Services\Contracts\UserSubmissionServiceContract;
use EscolaLms\Core\Models\User;
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
        $submission = [
            'access_url_id' => $accessUrl->getKey(),
            'email' => $data['email'],
            'frontend_url' => $data['frontend_url'],
            'status' => UserSubmissionEnum::EXPECTED
        ];

        return $this->userSubmissionRepository->create($submission);
    }

    public function accept(int $id): UserSubmission
    {
        $userSubmission = $this->userSubmissionRepository->update(['status' => UserSubmissionEnum::ACCEPTED], $id);

        $user = new User();
        $user->email = $userSubmission->email;

        UserSubmissionAccepted::dispatch($user, $userSubmission->frontend_url);

        return $userSubmission;
    }

    public function reject(int $id): UserSubmission
    {
        return $this->userSubmissionRepository->update(['status' => UserSubmissionEnum::REJECTED], $id);
    }

    public function search(array $search = []): LengthAwarePaginator
    {
        return $this->userSubmissionRepository->searchAndPaginate($search);
    }
}
