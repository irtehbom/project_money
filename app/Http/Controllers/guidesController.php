<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Products;
use App\Classes\AmazonECS;
use App\Classes\Settings;
use App\Helpers\HelperFunctions;
use App\Classes\productCategories;
use App\Classes\Slugs;
use App\Classes\Guides;

class guidesController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->products = new Products;
        $this->helpers = new helperFunctions;
        $this->settings = new Settings;
        $this->productCategories = new productCategories;
        $this->slugs = new Slugs;
        $this->guides = new Guides;
    }

    public function all(Request $request) {

        $all = $this->guides->all();

        return view('/buying_guides/all', [
            "all" => $all
        ]);
    }

    public function add() {

        $product_categories = $this->productCategories->all();
        $settings = $this->settings->first();
        $settings->location_ids = json_decode($settings->location_ids);

        return view('/buying_guides/add', [
            "product_categories" => $product_categories,
            "settings" => $settings
        ]);
    }

    public function edit() {

        $params = request()->route()->parameters();
        $product_categories = $this->productCategories->all();
        $get_object = $this->guides->where('id', $params["object_id"])->first();
        $settings = $this->settings->first();

        //var_dump($settings);

        $get_object->location_ids = json_decode($get_object->location_ids);

        $settings->location_ids = json_decode($settings->location_ids);

        $json = json_decode($get_object->products_order);

        /*
          $flatten_ids = array_map(function($e) {
          return is_object($e) ? $e->tag_id : $e['tag_id'];
          }, $json);
         */


        foreach ($json as $decoded) {

            if (count($decoded->data_id) != 0) {

                $product_ids = implode(',', $decoded->data_id);

                $get_products = $this->products->whereIn('id', $decoded->data_id)
                        ->orderByRaw(\DB::raw("FIELD(id, $product_ids)"))
                        ->get();

                $decoded->products = $get_products;
            }
        }


        $products = $this->products->where('category', $get_object->category)
                ->whereNotIn('id', json_decode($get_object->product_list))
                ->get();


        $brackets = '[' . $get_object->all_order . ']';

        $all_order = json_decode($brackets);

        $order_toString = implode(',', $all_order);


        $all_products = $this->products->where('category', $get_object->category)
                ->orderByRaw(\DB::raw("FIELD(id, $order_toString)"))
                ->get();


        return view('/buying_guides/edit', [
            "object" => $get_object,
            "settings" => $settings,
            "product_categories" => $product_categories,
            "products" => $products,
            "all_products" => $all_products,
            "json" => $json
        ]);
    }

    public function delete() {

        $params = request()->route()->parameters();
        $get_page = $this->guides->where('id', $params["object_id"])->first();
        $slug = $this->slugs->where('slug', $get_page->slug)->first();

        $get_page->delete();
        $slug->delete();

        return redirect('/buying_guides');
    }

    public function create(Request $request) {

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $input["all_order"] = str_replace('"', "", $input["all_order"]);
        $input["all_order"] = trim($input["all_order"], '[]');
        $input["location_ids"] = json_encode($input["location_ids"]);

        foreach ($input as $key => $value) {
            $this->guides->$key = $value;
        }

        $this->slugs->slug = $input['slug'];
        $this->slugs->type = 'guide';
        $this->slugs->save();

        $this->guides->save();

        return redirect('/buying_guides');
    }

    public function save(Request $request) {

        $input = $request->input();
        $params = request()->route()->parameters();

        $input["all_order"] = str_replace('"', "", $input["all_order"]);
        $input["all_order"] = trim($input["all_order"], '[]');
        $input["location_ids"] = json_encode($input["location_ids"]);

        $this->helpers->insertIfNotExsit($this->guides, $params["object_id"], $input, true);

        return redirect('/buying_guides');
    }

    public function getProducts(Request $request) {

        $input = $request->input();

        $products = $this->products->where('category', $input["category_selected"])->get();

        echo json_encode($products);
    }

}
