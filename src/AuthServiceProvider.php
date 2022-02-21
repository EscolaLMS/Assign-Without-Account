<?php

namespace EscolaLms\AssignWithoutAccount;

use EscolaLms\AssignWithoutAccount\Models\UserSubmission;
use EscolaLms\AssignWithoutAccount\Policies\AccessUrlPolicy;
use EscolaLms\AssignWithoutAccount\Policies\UserSubmissionPolicy;
use EscolaLms\UserAccess\Models\AccessUrl;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        AccessUrl::class => AccessUrlPolicy::class,
        UserSubmission::class => UserSubmissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached()) {
            Passport::routes();
        }
    }
}
