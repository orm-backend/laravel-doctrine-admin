<?php
namespace VVK\Admin;

use App\Model\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use VVK\Admin\Components\AboutComponent;
use VVK\Admin\Components\BreadcrumbsComponent;
use VVK\Admin\Components\BrieflyComponent;

class PackageServiceProvider extends ServiceProvider
{
    public function __construct($app) {
        parent::__construct($app);
    }
    
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
            __DIR__.'/../../../public/admin' => public_path('assets/admin')
        ], 'itaces-admin-assets');
        
        $this->publishes([
            __DIR__.'/../../../resources/views/admin' => resource_path('views/vendor/itaces/admin')
        ], 'itaces-admin-views');
        
        $this->publishes([
            __DIR__.'/../../../config/admin.php' => config_path('admin.php'),
        ], 'itaces-admin-config');
        
        Gate::define('dashboard', function (User $user) {
            return $user->getId() === 1 || $user->hasRole(config('itaces.roles.dashboard', 'dashboard'));
        });
        
        Gate::define('settings', function (User $user) {
            return $user->getId() === 1;
        });

        Blade::component('admin-about', AboutComponent::class);
        Blade::component('admin-breadcrumbs', BreadcrumbsComponent::class);
        Blade::component('admin-briefly', BrieflyComponent::class);
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
