<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'SiteController@index')
    ->name('home_page');
/* product */
Route::get('/catalog/{category}/{slug}', 'SiteController@product')
    ->name('site_product');
/* category */
Route::get('/catalog/{slug}', 'SiteController@category')
    ->name('site_category');
/* page */
//Route::get('/{slug}', 'SiteController@page')
//    ->name('site_page');
/* cart */
Route::get('/shopping-cart', 'SiteController@shoppingCart')
    ->name('shopping_cart');
Route::get('/add-to-cart/{id}/{option_id}', 'ProductController@addToCart')
    ->name('add_to_cart');
Route::get('/cart-increase/{product_id}/{option_id}', 'ProductController@incQuan')
    ->name('cart_increase');
Route::get('/cart-decrease/{product_id}/{option_id}', 'ProductController@decQuan')
    ->name('cart_decrease');
Route::get('cart-delete/{product_id}/{option_id}', 'ProductController@delItem')
    ->name('cart_delete');

Auth::routes();

/* orders */
Route::get('/admin', 'OrderController@index');
Route::get('/admin/orders', 'OrderController@index');
/* category */
Route::get('/admin/category', 'CategoryController@index')
    ->name('category_list');
Route::get('/admin/category/add', 'CategoryController@create');
Route::post('/admin/category/add', 'CategoryController@create')
    ->name('category_add');
Route::any('/admin/category/edit/{id}', 'CategoryController@update')
    ->name('category_edit');
/* page */
Route::get('/admin/page', 'PageController@index')
    ->name('page_list');
Route::get('/admin/homepage', 'PageController@homepage');
Route::post('/admin/homepage', 'PageController@homepage')
    ->name('page_home');
Route::get('/admin/page/add', 'PageController@create');
Route::post('/admin/page/add', 'PageController@create')
    ->name('page_add');
Route::any('/admin/page/edit/{id}', 'PageController@update')
    ->name('page_edit');
/* product */
Route::get('/admin/product', 'ProductController@index')
    ->name('product_list');
Route::any('/admin/product/add', 'ProductController@create')
    ->name('product_add');
Route::any('/admin/product/edit/{id}', 'ProductController@update')
    ->name('product_update');
/* options */
Route::get('/admin/option', 'OptionController@index')
    ->name('option_list');
Route::any('/admin/option/add', 'OptionController@create')
    ->name('option_add');
Route::any('/admin/option/update/{id}', 'OptionController@update')
    ->name('option_update');