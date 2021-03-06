<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapCommonRoutes();
        $this->mapErrorRoutes();
        $this->mapAdminRoutes();
        $this->mapSellerRoutes();
        $this->mapCustomerRoutes();
    }

    /**
     * 共通画面のルーティング
     */
    protected function mapCommonRoutes()
    {
        Route::middleware([ 'web', 'guards.auth' ])
            ->namespace($this->namespace)
            ->group(base_path('routes/web/common.php'));
    }

    /**
     * エラー画面のルーティング
     */
    protected function mapErrorRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/error.php'));
    }

    /**
     * 管理者画面のルーティング
     */
    protected function mapAdminRoutes()
    {
        Route::middleware([ 'web', 'auth', 'guards.users' ])
            ->prefix('admin')
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/web/admin.php'));
    }

    /**
     * 販売者画面のルーティング
     */
    protected function mapSellerRoutes()
    {
        Route::middleware([ 'web', 'auth', 'guards.users' ])
            ->prefix('seller')
            ->namespace($this->namespace . '\Seller')
            ->group(base_path('routes/web/seller.php'));
    }

    /**
     * 購入者画面のルーティング
     */
    protected function mapCustomerRoutes()
    {
        Route::middleware([ 'web', 'auth', 'guards.users' ])
            ->prefix('customer')
            ->namespace($this->namespace . '\Customer')
            ->group(base_path('routes/web/customer.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
