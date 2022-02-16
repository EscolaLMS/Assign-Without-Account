<?php

namespace EscolaLms\AssignWithoutAccount\Tests;

use EscolaLms\Core\Enums\UserRole;
use EscolaLms\AssignWithoutAccount\EscolaLmsAssignWithoutAccountServiceProvider;
use Laravel\Passport\PassportServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends \EscolaLms\Core\Tests\TestCase
{
    public $user;

    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            PassportServiceProvider::class,
            PermissionServiceProvider::class,
            EscolaLmsAssignWithoutAccountServiceProvider::class,
        ];
    }

    protected function authenticateAsAdmin(): void
    {
        $this->user = config('auth.providers.users.model')::factory()->create();
        $this->user->guard_name = 'api';
        $this->user->assignRole(UserRole::ADMIN);
    }
}
