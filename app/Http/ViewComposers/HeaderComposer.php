<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;
use App\Classes\Menus;

class HeaderComposer {

    protected $users;

    public function __construct(Menus $menus) {

        $this->menus = $menus;
    }

    public function compose(View $view) {
        
        $footer_menu = $this->menus->where('name', 'footer-menu')->first();

        if ($footer_menu != null) {
            $footer = json_decode($footer_menu->items);
        } else {
            $footer = null;
        }

        $main_menu = $this->menus->where('name', 'main-menu')->first();

        if ($main_menu != null) {
            $menu = json_decode($main_menu->items);
        } else {
            $menu = null;
        }

        $data = array(
            'menu' => $menu
        );

        $view->with('data', $data);
    }

}
