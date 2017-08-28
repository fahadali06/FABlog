<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User_Menu;
use Illuminate\Support\Facades\Auth;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public $SpecificMenu = [];

    public function boot() {

//        view()->composer(
//                'app', 'App\Http\ViewComposers\MenuComposer'
//        );

        view()->composer('*', function ($view) {
            $this->SpecificMenu = User_Menu::select('user_menu.*', 'menu.*')
                    ->join('menu', function($join) {
                        $join->on('user_menu.menu_id', '=', 'menu.id');
                    })
                    ->where('user_menu.user_id', isset(auth()->user()->id) ? auth()->user()->id : 0)
                    ->get()
                    ->toArray();

            $Menu = $this->SpecificMenu;
            $view->with(compact('Menu'));
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
