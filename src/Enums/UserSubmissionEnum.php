<?php

namespace EscolaLms\AssignWithoutAccount\Enums;

use EscolaLms\Core\Enums\BasicEnum;

class UserSubmissionEnum extends BasicEnum
{
    const REJECTED = 0;
    const EXPECTED = 1;
    const ACCEPTED = 2;
    const ASSIGNED = 3;
}
