<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Slugs;
use App\Classes\Guides;
use App\Classes\Products;
use App\Helpers\HelperFunctions;
use App\Classes\Pages;
use App\Classes\Settings;

class slugController extends Controller {

    public function __construct() {
        $this->slugs = new Slugs;
        $this->guides = new Guides;
        $this->pages = new Pages;
        $this->products = new Products;
        $this->settings = new Settings;
        $this->helpers = new helperFunctions;
    }

    public function get($slug = null, $result = null) {


        $page = $this->slugs->where('slug', $slug)->first();

        if ($page == null) {
            return view('404');
        }

        $type = $page->type;


        switch ($type) {
            case 'guide':

                $result = $this->guides->where('slug', $slug)->firstOrFail();

                $amazon = $this->helpers->getAmazonStore($result);

                $json = json_decode($result->products_order);

                $tag_list = array_map(function($e) {
                    return is_object($e) ? $e->tag_id : $e['tag_id'];
                }, $json);


                $prefixed_array = array();
                $size = count($tag_list);
                $counter = 0;
                $all_order_table = array();

                foreach ($json as $decoded) {
                    if (count($decoded->data_id) != 0) {
                        
                        $product_ids = implode(',', $decoded->data_id);
                        

                        $get_products = $this->products->whereIn('id', $decoded->data_id)
                                ->orderByRaw(\DB::raw("FIELD(id, $product_ids)"))
                                ->get();

                        $decoded->products = $get_products;

                        foreach ($decoded->products as $product) {
                            $product->selected_image_array = unserialize($product->selected_image_array);

                            if ($product->key_features != null) {
                                $product->key_features = json_decode($product->key_features);
                            }
                        }
                    }
                }
                
                $all_order_to_array = explode(',', $result->all_order);
                
                foreach ($all_order_to_array as $all_order) {
                    
                    $products = $this->products->where('id', $all_order)
                                ->orderByRaw(\DB::raw("FIELD(id, $result->all_order)"))
                                ->get();
                    
                    array_push($all_order_table,$products);

                }
   
                foreach ($tag_list as $tag) {
                    if (++$counter == $size) {
                        $tag = '.' . $tag;
                    } else {
                        $tag = '.' . $tag . ',';
                    }
                    array_push($prefixed_array, $tag);
                }

                $formatted = implode(" ", $prefixed_array);
                


                return view('/buying_guides/template', [
                    "result" => $result,
                    "json" => $json,
                    "tag_list" => $formatted,
                    "amazon" => $amazon,
                    "all_order_table" => $all_order_table
                ]);

                break;

            case 'page':

                $result = $this->pages->where('slug', $slug)->firstOrFail();

                if ($result->homepage == 1) {
                    return redirect('/');
                }

                return view('/pages/template', [
                    "result" => $result
                ]);

                break;

            case 'blog':

                break;
        }



        //To be used for custom templates later down the line
        //return view($page->template)->with('page', $page);
    }

    public function getHomepage() {

        $settings = $this->settings->first();

        $guides = $this->guides->all();

        $result = $this->pages->where('id', $settings->homepage)->firstOrFail();

        return view('/homepage/template', [
            "result" => $result,
            "guides" => $guides
        ]);
    }

}
