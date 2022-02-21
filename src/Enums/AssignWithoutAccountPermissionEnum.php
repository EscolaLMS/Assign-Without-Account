<?php

namespace EscolaLms\AssignWithoutAccount\Enums;

use EscolaLms\Core\Enums\BasicEnum;

class AssignWithoutAccountPermissionEnum extends BasicEnum
{
    const ACCESS_URL_CREATE = 'assign-without-account_access-url_create';
    const ACCESS_URL_DELETE = 'assign-without-account_access-url_delete';
    const ACCESS_URL_UPDATE = 'assign-without-account_access-url_update';
    const ACCESS_URL_LIST = 'assign-without-account_access-url_list';

    const USER_SUBMISSION_LIST = 'assign-without-account-user-submission_list';
    const USER_SUBMISSION_ACCEPT = 'assign-without-account_user-submission_accept';
    const USER_SUBMISSION_REJECT = 'assign-without-account_user-submission_reject';
}
