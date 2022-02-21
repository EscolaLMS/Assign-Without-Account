<?php

namespace EscolaLms\AssignWithoutAccount\Repositories;

use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\Core\Repositories\BaseRepository;
use EscolaLms\AssignWithoutAccount\Repositories\Contracts\UserSubmissionRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserSubmissionRepository extends BaseRepository implements UserSubmissionRepositoryContract
{
    public function getFieldsSearchable()
    {
        return [
            'email',
            'status'
        ];
    }

    public function model()
    {
        return UserSubmission::class;
    }

    public function searchAndPaginate(array $search = [], ?int $perPage = null, string $orderDirection = 'asc', string $orderColumn = 'id'): LengthAwarePaginator
    {
        return $this->allQuery($search)->orderBy($orderColumn, $orderDirection)->paginate($perPage);
    }
}
