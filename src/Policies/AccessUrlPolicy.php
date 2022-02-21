<?php

namespace EscolaLms\AssignWithoutAccount\Policies;

use EscolaLms\AssignWithoutAccount\Enums\AssignWithoutAccountPermissionEnum;
use EscolaLms\Core\Models\User;
use EscolaLms\AssignWithoutAccount\Models\AccessUrl;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessUrlPolicy
{
    use HandlesAuthorization;

    public function list(User $user): bool
    {
        return $user->can(AssignWithoutAccountPermissionEnum::ACCESS_URL_LIST);
    }

    public function create(User $user): bool
    {
        return $user->can(AssignWithoutAccountPermissionEnum::ACCESS_URL_CREATE);
    }

    public function update(User $user, AccessUrl $accessUrl): bool
    {
        return $user->can(AssignWithoutAccountPermissionEnum::ACCESS_URL_UPDATE);
    }

    public function delete(User $user, AccessUrl $accessUrl): bool
    {
        return $user->can(AssignWithoutAccountPermissionEnum::ACCESS_URL_DELETE);
    }
}
