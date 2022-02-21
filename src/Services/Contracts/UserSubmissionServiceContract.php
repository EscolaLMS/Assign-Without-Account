<?php

namespace EscolaLms\AssignWithoutAccount\Services\Contracts;

use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserSubmissionServiceContract
{
    public function create(AccessUrl $accessUrl, array $data): UserSubmission;

    public function accept(int $id): UserSubmission;

    public function reject(int $id): UserSubmission;

    public function search(array $search = []): LengthAwarePaginator;
}
