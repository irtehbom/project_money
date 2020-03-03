<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Products;
use App\Classes\AmazonECS;
use App\Classes\Settings;
use App\Helpers\HelperFunctions;
use App\Classes\productCategories;
use App\Classes\Pages;
use App\Classes\Slugs;

class pagesController extends Controller {
    
    

    public function __construct() {
        
        $this->middleware('auth');
        $this->products = new Products;
        $this->helpers = new helperFunctions;
        $this->settings = new Settings;
        $this->productCategories = new productCategories;
        $this->slugs = new Slugs;
        $this->pages = new Pages;
    }
    
    //gets

    public function all() {

        $all = $this->pages->all();

        return view('/pages/all', [
            "all" => $all
        ]);
    }

    public function add() {

        $product_categories = $this->productCategories->all();

        return view('/pages/add', [
            "product_categories" => $product_categories
        ]);
    }

    public function edit() {

        $params = request()->route()->parameters();
        $product_categories = $this->productCategories->all();
        $get_object = $this->pages->where('id', $params["object_id"])->first();
        $settings = $this->settings->first();

        return view('/pages/edit', [
            "object" => $get_object,
            "settings" => $settings,
            "product_categories" => $product_categories
        ]);
    }

    public function delete() {

        $params = request()->route()->parameters();
        $get_page = $this->pages->where('id', $params["object_id"])->first();
        $slug = $this->slugs->where('slug', $get_page->slug)->first();
        
        $get_page->delete();
        $slug->delete();
        
        return redirect('/pages');
    }

    //posts
    
    public function create(Request $request) {

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        foreach ($input as $key => $value) {
            $this->pages->$key = $value;
        }
        
        $this->slugs->slug = $input['slug'];
        $this->slugs->type = 'page';
        $this->slugs->save();

        $this->pages->save();

        return redirect('/pages');
    }
    
    public function save(Request $request) {

        $input = $request->input();
        $params = request()->route()->parameters();

        $this->helpers->insertIfNotExsit($this->pages, $params["object_id"], $input, true);

        return redirect('/pages');
    }

    public function getProducts(Request $request) {

        $input = $request->input();

        $products = $this->products->where('category', $input["category_selected"])->get();

        echo json_encode($products);
    }
    


}
