<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Menu;
use App\User_Menu;

class MovieComposer {

    public $SpecificMenu = [];

    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct() {
//        $this->SpecificMenu = User_Menu::select('user_menu.*', 'menu.*')
//                ->join('menu', function($join){
//                    $join->on('user_menu.menu_id', '=', 'menu.id');
//                })
//                ->where('user_menu.user_id', auth()->user()->id)
//                ->toArray();
        $this->SpecificMenu = ['abcd' => 'abcd'];
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view) {
        $view->with('SpecificMenu', $this->SpecificMenu);
    }

}
