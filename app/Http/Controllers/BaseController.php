<?php namespace App\Http\Controllers;

use View;

//You can create a BaseController:

class BaseController extends Controller {

    public $variable1 = "I am Data";

    public function __construct() {

       $variable2 = "I am Data 2";


       View::share ( 'variable1', $this->variable1 );
       View::share ( 'variable2', $variable2 );
       View::share ( 'variable3', 'I am Data 3' );
       View::share ( 'variable4', ['name'=>'Franky','address'=>'Mars'] );
    }  

}

class HeaderController extends BaseController {

    //if you have a constructor in other controllers you need call constructor of parent controller (i.e. BaseController) like so:

    public function __construct(){
       parent::__construct();
    }

    public function Index(){
      //All variable will be available in views
      return view('header/header');
    }

}