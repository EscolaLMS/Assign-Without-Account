<?php

namespace EscolaLms\AssignWithoutAccount\Policies;

use EscolaLms\AssignWithoutAccount\Enums\AssignWithoutAccountPermissionEnum;
use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\Core\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSubmissionPolicy
{
    use HandlesAuthorization;

    public function list(User $user): bool
    {
        return $user->can(AssignWithoutAccountPermissionEnum::USER_SUBMISSION_LIST);
    }

    public function accept(User $user, UserSubmission $userSubmission): bool
    {
        return $user->can(AssignWithoutAccountPermissionEnum::USER_SUBMISSION_ACCEPT);
    }

    public function reject(User $user, UserSubmission $userSubmission): bool
    {
        return $user->can(AssignWithoutAccountPermissionEnum::USER_SUBMISSION_REJECT);
    }
}
