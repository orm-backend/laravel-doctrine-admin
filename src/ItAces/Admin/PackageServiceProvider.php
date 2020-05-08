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
        $this->loadRoutesFrom(__DIR__.'/../../routes.php');
        
        $this->loadViewsFrom(__DIR__.'/../../../resources/views', 'itaces');

        $this->publishes([
            __DIR__.'/../../../public/admin' => public_path('assets/admin'),
            //__DIR__.'/../../../resources/views' => resource_path('views/vendor/itaces'),
        ], 'public');
        
        $this->publishes([
            __DIR__.'/../../../config/admin.php' => config_path('admin.php'),
        ], 'config');
        
        Gate::define('dashboard-access', function ($user) {
            return $user->hasDashboardAccess();
        });
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../../config/admin.php', 'admin'
        );
    }

}
