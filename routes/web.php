<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::prefix('product')->group(function () {

    Route::get('','ProductController@index')->name('product.index')->middleware("auth");
    Route::get('create', 'ProductController@create')->name('product.create')->middleware("auth");
    Route::post('store', 'ProductController@store')->name('product.store')->middleware("auth");
    Route::get('edit/{product}', 'ProductController@edit')->name('product.edit')->middleware("auth");
    Route::post('update/{product}', 'ProductController@update')->name('product.update')->middleware("auth");
    Route::post('delete/{product}', 'ProductController@destroy')->name('product.destroy')->middleware("auth");
    Route::get('show/{product}', 'ProductController@show')->name('product.show')->middleware("auth");
    Route::get('/pdf{product}','ProductController@generateBook')->name('product.pdf')->middleware("auth");
    Route::get('/pdf','ProductController@generatePDF')->name('products.pdf')->middleware("auth");

});

Route::prefix('category')->group(function () {

    Route::get('','CategoryController@index')->name('category.index')->middleware("auth");
    Route::get('create', 'CategoryController@create')->name('category.create')->middleware("auth");
    Route::post('store', 'CategoryController@store')->name('category.store')->middleware("auth");
    Route::get('edit/{category}', 'CategoryController@edit')->name('category.edit')->middleware("auth");
    Route::post('update/{category}', 'CategoryController@update')->name('category.update')->middleware("auth");
    Route::post('delete/{category}', 'CategoryController@destroy')->name('category.destroy')->middleware("auth");
    Route::get('show/{category}', 'CategoryController@show')->name('category.show')->middleware("auth");

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
