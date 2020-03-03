<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('front_page');
    
});

Route::get('/', 'slugController@getHomepage');

Route::get('/file_manager_add/', 'FileManagerController@add_view');
Route::get('/file_manager_all/', 'FileManagerController@all_view');

Route::post('/file_manager/add', 'FileManagerController@add');
Route::post('/file_manager/update', 'FileManagerController@update');
Route::post('/file_manager/delete', 'FileManagerController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/settings', 'settingsController@settingsView');
Route::post('/settings/update_settings', 'settingsController@settingsUpdate');

Route::get('products', 'productsController@allProducts');
Route::get('products/add_product', 'productsController@addProduct');
Route::get('products/edit_product/{product_id}', 'productsController@editProduct');
Route::get('products/delete_product/{product_id}', 'productsController@deleteProduct');
Route::post('products/load_amazon_data', 'productsController@loadAmazonData');
Route::post('products/edit_product/{product_id}', 'productsController@editProductSave');
Route::post('products/add_product', 'productsController@addProductSave');

Route::get('all_product_categories', 'productCategoryController@allCategories');
Route::get('all_product_categories/edit/{category_id}', 'productCategoryController@categoryEditView');
Route::post('all_product_categories/edit/{category_id}', 'productCategoryController@categoryEdit');
Route::get('all_product_categories/delete/{category_id}', 'productCategoryController@delete');
Route::post('all_product_categories', 'productCategoryController@categorySave');


Route::get('pages', 'pagesController@all');
Route::get('pages/add', 'pagesController@add');
Route::get('pages/edit/{object_id}', 'pagesController@edit');
Route::get('pages/delete/{object_id}', 'pagesController@delete');
Route::post('pages/add', 'pagesController@create');
Route::post('pages/edit/{object_id}', 'pagesController@save');
Route::post('pages/add/get_products', 'pagesController@getProducts');
Route::post('pages/homepagecheck', 'pagesController@homePageCheck');



Route::get('buying_guides', 'guidesController@all');
Route::get('buying_guides/add', 'guidesController@add');
Route::get('buying_guides/edit/{object_id}', 'guidesController@edit');
Route::get('buying_guides/delete/{object_id}', 'guidesController@delete');
Route::post('buying_guides/add', 'guidesController@create');
Route::post('buying_guides/edit/{object_id}', 'guidesController@save');
Route::post('buying_guides/add/get_products', 'guidesController@getProducts');
Route::post('buying_guides/add/get_products_on_load', 'guidesController@getProductsOnLoad');

Route::get('menu', 'menuController@all');
Route::get('menu/edit/{object_id}', 'menuController@edit');
Route::post('menu/edit/{object_id}', 'menuController@save');
Route::post('menu/add', 'menuController@create');
Route::post('menu/add', 'menuController@create');
Route::get('menu/delete/{object_id}', 'menuController@delete');

Route::get('widgets', 'widgetController@all');
Route::post('widgets/get_data', 'widgetController@getData');

Route::get('{slug}', [
    'uses' => 'slugController@get' 
])->where('slug', '([A-Za-z0-9\-\/]+)');