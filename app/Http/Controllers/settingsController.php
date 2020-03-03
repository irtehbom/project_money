<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Settings;
use App\Helpers\HelperFunctions;
use App\Classes\Pages;
use App\Classes\Media;

class settingsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->settings = new Settings;
        $this->pages = new Pages;
        $this->helpers  = new helperFunctions;
        $this->media = new Media();
    }

    public function settingsView() {
        
        $object = $this->settings->first();
        
        $pages = $this->pages->all();

        $object->location_ids = json_decode($object->location_ids);

        $all = $this->media->all();
        
        return view('/settings/settings', [
            "object" => $object,
            "pages" => $pages,
            "all" => $all
        ]);

    }

    public function settingsUpdate(Request $request) {
        
        $input = $request->input();

        
        $input['location_ids'] = json_encode($input['location_ids']);
        
        $resetHomepage = $this->pages->where('homepage', 1)->first();
        $resetHomepage->homepage = null;
        $resetHomepage->save();
        
        $page = $this->pages->where('id', $input['homepage'])->first();
        
        
        $page->homepage = 1;
        $page->save();

        $this->helpers->insertIfNotExsit($this->settings, 1, $input);

        return redirect('/settings/');
    }
}
