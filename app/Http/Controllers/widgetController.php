<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Settings;
use App\Helpers\HelperFunctions;
use App\Classes\Pages;
use App\Classes\Guides;
use App\Classes\Menus;

class widgetController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->helpers = new helperFunctions;
        $this->settings = new Settings;
        $this->pages = new Pages;
        $this->guides = new Guides;
        $this->menus = new Menus;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function all() {

        $pages = $this->pages->all();
        $guides = $this->guides->all();
        $menus = $this->menus->all();


        return view('appearance/widgets/all', [
            "pages" => $pages,
            "guides" => $guides,
            "menus" => $menus
        ]);
    }

    public function getData(Request $request) {

        $input = $request->input();
        $returnArr = array();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        switch ($input['type']) {

            case 'menu':
                
                $returnArr['type'] = 'menu';
                $returnArr['data'] = $this->menus->all()->toJson();
            break;
        }
        
        return $returnArr;
    }

    public function delete() {

        $params = request()->route()->parameters();
        $get_object = $this->menus->where('id', $params["object_id"])->first();
        $get_object->delete();

        return redirect('menu');
    }

    public function create(Request $request) {

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        foreach ($input as $key => $value) {
            $this->menus->$key = $value;
        }

        $this->menus->save();

        return redirect('/menu');
    }

    public function save(Request $request) {

        $input = $request->input();
        $params = request()->route()->parameters();
        $this->helpers->insertIfNotExsit($this->menus, $params["object_id"], $input);

        return redirect('/menu');
    }

}
