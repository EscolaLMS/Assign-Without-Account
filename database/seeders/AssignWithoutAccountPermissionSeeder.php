<?php

namespace EscolaLms\AssignWithoutAccount\Database\Seeders;


use EscolaLms\AssignWithoutAccount\Enums\AssignWithoutAccountPermissionEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Seeder;

class AssignWithoutAccountPermissionSeeder extends Seeder
{
    public function run()
    {
        $admin = Role::findOrCreate('admin', 'api');

        foreach (AssignWithoutAccountPermissionEnum::asArray() as $const => $value) {
            Permission::findOrCreate($value, 'api');
        }

        $admin->givePermissionTo([
            AssignWithoutAccountPermissionEnum::ACCESS_URL_CREATE,
            AssignWithoutAccountPermissionEnum::ACCESS_URL_DELETE,
            AssignWithoutAccountPermissionEnum::ACCESS_URL_UPDATE,
            AssignWithoutAccountPermissionEnum::ACCESS_URL_LIST,
            AssignWithoutAccountPermissionEnum::USER_SUBMISSION_LIST,
            AssignWithoutAccountPermissionEnum::USER_SUBMISSION_ACCEPT,
            AssignWithoutAccountPermissionEnum::USER_SUBMISSION_REJECT,
        ]);
    }
}
