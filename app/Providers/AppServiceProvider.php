<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $menuCategories = Category::where('status', '1')->orderBy('name', 'asc')->get();

        view()->composer('layouts.header', function ($view) use($menuCategories) {
            $view->with('menuCategories', $menuCategories);
        });
    }
}
