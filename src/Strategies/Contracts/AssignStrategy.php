<?php

namespace EscolaLms\AssignWithoutAccount\Strategies\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface AssignStrategy
{
    public function assign(Authenticatable $user, int $modelId): bool;
}
