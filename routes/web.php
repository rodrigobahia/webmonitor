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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//SITES
Route::get('/sites/create','SiteController@create')->name('sites.create');
Route::post('/sites/store','SiteController@store')->name('sites.store');
Route::post('/sites/update/{id}','SiteController@update')->name('sites.update');
Route::get('/sites/edit/{id}','SiteController@edit')->name('sites.edit');
Route::delete('/siter/destroy/{id}','SiteController@destroy')->name('sites.destroy');