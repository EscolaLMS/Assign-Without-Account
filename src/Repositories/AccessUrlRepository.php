<?php

namespace EscolaLms\AssignWithoutAccount\Repositories;

use EscolaLms\Core\Repositories\BaseRepository;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use EscolaLms\AssignWithoutAccount\Repositories\Contracts\AccessUrlRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class AccessUrlRepository extends BaseRepository implements AccessUrlRepositoryContract
{
    public function getFieldsSearchable()
    {
        return [
            'url',
            'modelable_id',
            'modelable_type',
        ];
    }

    public function model()
    {
        return AccessUrl::class;
    }

    public function search(array $search = [], string $orderDirection = 'asc', string $orderColumn = 'id'): Collection
    {
        return $this->allQuery($search)->orderBy($orderColumn, $orderDirection)->get();
    }
}
