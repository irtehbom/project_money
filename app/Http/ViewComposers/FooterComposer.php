<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;
use App\Classes\Menus;
use App\Classes\Pages;

class FooterComposer {

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

        $data = array(
            'footer' => $footer
        );

        $view->with('data', $data);
    }

}
