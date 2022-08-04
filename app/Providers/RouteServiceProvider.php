<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('user', function ($value, $route) {
            return $this->getModel(\App\User::class, $value);
        });

        Route::bind('creator', function ($value, $route) {
            return $this->getModel(\App\User::class, $value);
        });

        Route::bind('cms-page', function ($value, $route) {
            return $this->getModel(\App\CmsPage::class, $value);
        });

        Route::bind('content', function ($value, $route) {
            return $this->getModel(\App\Content::class, $value);
        });

        Route::bind('category', function ($value, $route) {
            return $this->getModel(\App\Category::class, $value);
        });

        Route::bind('enquiry', function ($value, $route) {
            return $this->getModel(\App\Enquiry::class, $value);
        });

        Route::bind('social-account', function ($value, $route) {
            return $this->getModel(\App\SocialAccount::class, $value);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapAdminRoutes();
        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
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

    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        // Route::domain('admin.scanit.in')
        Route::prefix('admin')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    private function getModel($model, $routeKey)
    {
        $id = \Hashids::decode($routeKey)[0] ?? null;
        $modelInstance = resolve($model);

        return  $modelInstance->findOrFail($id);
    }
}
