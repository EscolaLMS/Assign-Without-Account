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

        // TODO delete old permissions

        foreach (AssignWithoutAccountPermissionEnum::asArray() as $const => $value) {
            Permission::findOrCreate($value, 'api');
        }

        $admin->givePermissionTo([
            AssignWithoutAccountPermissionEnum::USER_SUBMISSION_LIST,
            AssignWithoutAccountPermissionEnum::USER_SUBMISSION_CREATE,
        ]);
    }
}
