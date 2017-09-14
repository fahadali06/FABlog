<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\BlogCategory;
use App\Blogs;
use Illuminate\Support\Facades\DB;

class ArchivePostProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        view()->composer('*', function ($view) {
            $ArchiveBlog = Blogs::select(DB::raw('DATE_FORMAT(blogs.created_at, "%b-%Y") as created_date'))->with('blogcategory')
                    ->with('bloguser')
                    ->limit(3)
                    ->orderBy('blogs.id', 'created_date')
                    ->groupBy('created_date')
                    ->get()
                    ->toArray();
            $view->with(compact('ArchiveBlog'));
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
