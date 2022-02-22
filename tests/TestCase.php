<?php

namespace EscolaLms\AssignWithoutAccount\Tests;

use EscolaLms\Auth\EscolaLmsAuthServiceProvider;
use EscolaLms\Core\Enums\UserRole;
use EscolaLms\AssignWithoutAccount\EscolaLmsAssignWithoutAccountServiceProvider;
use EscolaLms\Core\Models\User;
use EscolaLms\Courses\EscolaLmsCourseServiceProvider;
use EscolaLms\Scorm\EscolaLmsScormServiceProvider;
use EscolaLms\Tags\EscolaLmsTagsServiceProvider;
use EscolaLms\Templates\EscolaLmsTemplatesServiceProvider;
use EscolaLms\TopicTypes\EscolaLmsTopicTypesServiceProvider;
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
            EscolaLmsAuthServiceProvider::class,
            EscolaLmsCourseServiceProvider::class,
            EscolaLmsTagsServiceProvider::class,
            EscolaLmsTopicTypesServiceProvider::class,
            EscolaLmsScormServiceProvider::class,
            EscolaLmsTemplatesServiceProvider::class,
            EscolaLmsAssignWithoutAccountServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('passport.client_uuids', true);
    }

    protected function authenticateAsAdmin(): void
    {
        $this->user = config('auth.providers.users.model')::factory()->create();
        $this->user->guard_name = 'api';
        $this->user->assignRole(UserRole::ADMIN);
    }

    protected function authenticatedUser(): void
    {
        $this->user = config('auth.providers.users.model')::factory()->create();
        $this->user->guard_name = 'api';
    }
}
