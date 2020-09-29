<?php

namespace App\Providers;

use App\Policies\DmsCategoryPolicy;
use App\Policies\DmsKeywordPolicy;
use App\Policies\DmsDocumentPolicy;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\DmsCategory' => 'App\Policies\DmsCategoryPolicy',
        'App\DmsKeyword' => 'App\Policies\DmsKeywordPolicy',
        'App\DmsDocument' => 'App\Policies\DmsDocumentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Passport::routes(null, ['middleware' => 'access_log']);
        Passport::tokensExpireIn(now()->addYears(5));
        Passport::refreshTokensExpireIn(now()->addYears(5));
        Passport::personalAccessTokensExpireIn(now()->addYears(5));

    }
}
