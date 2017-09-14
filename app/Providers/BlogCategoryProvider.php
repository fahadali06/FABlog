<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\BlogCategory;

class BlogCategoryProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        view()->composer('*', function ($view) {
            $BlogCategoryList = BlogCategory::all()->where('status', 'Yes')->toArray();
            $view->with(compact('BlogCategoryList'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
