<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider {

    public function boot()
    {
        View::composer('/header/header', 'App\Http\ViewComposers\HeaderComposer');
        View::composer('/footer/footer', 'App\Http\ViewComposers\FooterComposer');
    }

   
    public function register()
    {

    }

}