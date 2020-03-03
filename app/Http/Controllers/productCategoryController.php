<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\productCategories;
use App\Classes\Products;

use App\Helpers\HelperFunctions;

class productCategoryController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->productCategories = new productCategories;
        $this->helpers = new helperFunctions;
        $this->products = new Products;
    }
    
    public function allCategories() {
        
        $all_categories = $this->productCategories->all();

        foreach ($all_categories as $category) {
            $category->productCount = $this->products->where('category', $category->id )->count();
        }

        return view('product_categories/all_product_categories', [
            "product_categories" => $all_categories
        ]);

    }
    
    public function categorySave(Request $request) {
        
        $input = $request->input();
        
        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        foreach ($input as $key => $value) {
            $this->productCategories->$key = $value;
        }

        $this->productCategories->save();

        return redirect('all_product_categories');
    }
    
    public function categoryEditView() {
        
       
        $params = request()->route()->parameters();

        $get_category = $this->productCategories->where('id', $params["category_id"])->first();
        
        $products = $this->products->where('category', $params["category_id"])->get();
        

        return view('product_categories/edit', [
            "category" => $get_category,
            "products" => $products
        ]);

    }
    
    public function categoryEdit(Request $request) {
       
        $input = $request->input();
        $params = request()->route()->parameters();
       
        $this->helpers->insertIfNotExsit($this->productCategories, $params["category_id"], $input);

        return redirect('all_product_categories');

    }
    
    public function delete() {

        $params = request()->route()->parameters();
        $cat = $this->productCategories->where('id', $params["category_id"])->first();
       
        $cat->delete();
        
        return redirect('all_product_categories');
    }

    
}
