<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Products;
use App\Classes\AmazonECS;
use App\Classes\Settings;
use App\Helpers\HelperFunctions;
use App\Classes\productCategories;

class productsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->products = new Products;
        $this->helpers = new helperFunctions;
        $this->settings = new Settings;
        $this->productCategories = new productCategories;
    }

    public function allProducts() {
        $all_products = $this->products->all();


        return view('/products/products', [
            "products" => $all_products
        ]);
    }

    public function addProduct() {

        $settings = $this->settings->first();
        $product_categories = $this->productCategories->all();

        return view('/products/add_product', [
            "settings" => $settings,
            "product_categories" => $product_categories
        ]);
    }

    public function addProductSave(Request $request) {
        

        
        $input = $request->input();
        $input['selected_image_array'] = serialize(explode(",", $input['selected_image_array']));
        array_pop($input['key_features']);
        $input['key_features'] = json_encode($input['key_features']); 

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $get_category = $this->productCategories->where('id', $request->input('category'))->first();
        $this->products->category_name = $get_category->category_name;

        foreach ($input as $key => $value) {
            $this->products->$key = $value;
        }

        $this->products->save();

        return redirect('/products');
    }

    public function editProduct() {

        $params = request()->route()->parameters();

        $get_product = $this->products->where('id', $params["product_id"])->first();
        $settings = $this->settings->first();
        $product_categories = $this->productCategories->all();

        $get_product->selected_image_array = unserialize($get_product->selected_image_array);
        $get_product->key_features = json_decode($get_product->key_features); 

        return view('/products/edit_product', [
            "product" => $get_product,
            "settings" => $settings,
            "product_categories" => $product_categories
        ]);
    }

    public function editProductSave(Request $request) {

        $input = $request->input();
        $params = request()->route()->parameters();
        $input['selected_image_array'] = serialize(explode(",", $input['selected_image_array']));
        
        array_pop($input['key_features']);

        $input['key_features'] = json_encode($input['key_features']); 

        $this->helpers->insertIfNotExsit($this->products, $params["product_id"], $input);
        

        return redirect('/products');
    }

    public function deleteProduct() {
        
        $params = request()->route()->parameters();
        $product = $this->products->where('id', $params["product_id"])->first();
        
        $product->delete();

        
        return redirect('/products');
    }

    public function loadAmazonData(Request $request) {

        $asin = $request->input('asin');
        $settings = $this->settings->first();
        
        $getSettings = $this->helpers->getAmazonApiLocale($settings);
        
        $amazon = new AmazonECS($getSettings['tag'], $getSettings['local']);
        $product = $amazon->lookup($asin)->json();


        if (isset($product['Items']['Request']['Errors']['Error']['Message'])) {

            echo json_encode('ASIN Incorrect');
        } else {

            //$prices = $this->loadPrices($product);
            $prices = array();
            $images = $this->loadImages($product);

            echo json_encode(array($prices, $images));
        }
    }

    public function loadImages($product) {

        $product_images = $product['Items']['Item']['ImageSets']['ImageSet'];

        $mediumImage = array();

        foreach ($product_images as $image) {

            $mediumImage[] = $image['LargeImage'];
        }

        $largeImage = array_map("unserialize", array_unique(array_map("serialize", $mediumImage)));

        return array($largeImage);
    }

    /*

      public function loadPrices($product) {


      if (isset($product['Items']['Item']['OfferSummary']['LowestNewPrice'])) {
      $lowestPrice = $product['Items']['Item']['OfferSummary']['LowestNewPrice'];
      } else {
      $lowestPrice = 'not_found';
      }


      if (isset($product['Items']['Item']['OfferSummary']['LowestUsedPrice'])) {
      $lowestUsedPrice = $product['Items']['Item']['OfferSummary']['LowestUsedPrice'];
      } else {
      $lowestUsedPrice = 'not_found';
      }


      return array($lowestPrice, $lowestUsedPrice);
      }
     */
}
