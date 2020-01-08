<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Gate;
use Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * Define permissions
         */
        try {
            if (Schema::hasTable('permissions')) {
                foreach ($this->getPermissions() as $permission) {
                    Gate::define($permission->label, function (User $user) use ($permission) {
                        return $user->hasRole($permission->roles);
                    });
                }
            }
        } catch (Exception $e) {
            //
        }
    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
