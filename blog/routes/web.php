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
    return redirect("/login");
});
Auth::routes();
Route::post('/home', 'HomeController@delete');
Route::post('/home', 'HomeController@add');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/detail', 'HomeController@detail');
Route::get('/home/edit{barcode}', 'HomeController@editItem')->name('edit');
Route::patch('/home/edit', 'HomeController@updateItem');
Route::get('/home/logout', 'HomeController@logout');
Route::get('/home/overzicht/itemsWithoutUser', 'HomeController@overviewWithoutUser');
Route::get('/home/overzicht/filter', 'HomeController@filter');
Route::post('/home/overzicht/search', 'HomeController@search');

Route::get('/home/overzicht', 'HomeController@overzicht');
Route::get('/home/overzicht/houdbaarheid', 'HomeController@overzichtHoudbaar');
Route::get('/home/grocerylist', 'HomeController@grocerylist');
Route::patch('/home/grocerylist/delete', 'boodschappenController@delete');
Route::patch('/home/grocerylist/add', 'boodschappenController@add');
Route::get('/home/grocerylist/edit', 'boodschappenController@edit');
Route::patch('/home/grocerylist/editItem', 'boodschappenController@editItem');

Route::get('/home/admin', 'HomeController@admin')->middleware(['auth', 'checkrole']);
Route::get('/home/admin/undo', 'HomeController@recover');
Route::patch('/home/delete', 'HomeController@delete');
