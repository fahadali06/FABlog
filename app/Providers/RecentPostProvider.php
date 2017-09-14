<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\BlogCategory;
use App\Blogs;

class RecentPostProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        view()->composer('*', function ($view) {
            $RecentBlog = Blogs::with(['blogcategory' => function($blogs) {
                            
                        }])
                    ->with(['bloguser' => function($user) {
                            
                        }])
                    ->limit(3)
                    ->orderBy('blogs.id', 'desc')
                    ->get()
                    ->toArray();
            $view->with(compact('RecentBlog'));
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
