<?php
namespace ItAces\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/../../routes.php';
        
        $this->publishes([
            __DIR__.'/../../../resources/admin' => base_path('/resources/admin'),
            __DIR__.'/../../../resources/views/admin' => base_path('/resources/views/admin'),
        ], 'itaces');
        
        Gate::define('dashboard-access', function ($user) {
            return $user->hasDashboardAccess();
        });
    }

}
