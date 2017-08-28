<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use App\User_Menu;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class UserServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $useraccess = "";
        view()->composer('*', function ($view) {
            $url = Request::path();

            $useraccess = User::select(DB::raw('count("users.id") as userid'))->join('user_menu', function($join) {
                                $join->on('user_menu.user_id', '=', 'users.id');
                            })
                            ->join('menu', function($join) {
                                $join->on('menu.id', '=', 'user_menu.menu_id');
                            })
                            ->where(['menu.slug' => $url, 'users.id' => isset(auth()->user()->id) ? auth()->user()->id : 0])
                                ->whereNotNull('menu.slug')
                            ->get()->first();
                
            $view->with(compact('useraccess'));
            
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
