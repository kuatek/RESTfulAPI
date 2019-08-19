<?php

namespace App\Providers;

use App\Buyer;
use App\Policies\BuyerPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Mockery\Generator\StringManipulation\Pass\Pass;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();
        Passport::tokensCan([
            'purchase-product'=>'Create a new transaction for a specific product',
            'manage-products'=>'Create, read, update, and delete products',
            'manage-account'=>'Read your account data, id, name, email, if verified,
                               and if admin(cannot read password). Cannot delete your account',
            'read-general'=>'Read general information like purchasing categories, 
                             purchased products, selling categories, your transactions, (purchases and sales)'
        ]);
    }

}
