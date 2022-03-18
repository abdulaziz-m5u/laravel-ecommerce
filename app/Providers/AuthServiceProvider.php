<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

        $user = auth()->user();
        
        if (! app()->runningInConsole()) {
            $roles = Role::with('permissions')->get();

            foreach ($roles as $role) {
                foreach ($role->permissions as $permission) {
                    $permissionArray[$permission->title][] = $role->id;
                }
            }

            foreach ($permissionArray as $title => $roles) {
                Gate::define($title, function (User $user) use ($roles) {
                    return count(array_intersect($user->roles->pluck('id')->toArray(), $roles));
                });
            }
        }
    }
}
