<?php

namespace EscolaLms\AssignWithoutAccount\Repositories\Contracts;

use EscolaLms\Core\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

interface AccessUrlRepositoryContract extends BaseRepositoryContract
{
    public function search(array $search = [], string $orderDirection = 'asc', string $orderColumn = 'id'): Collection;
}
