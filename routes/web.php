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


Route::group(['prefix' => '/cms'], function () {

    Route::group(['prefix' => '/carousel'], function () {
        Route::get('/', 'HomeCarouselController@index')->name('home_page_carousel');
        Route::post('/image_uploader_modal', 'HomeCarouselController@image_uploader_modal')->name('image_uploader_modal');
        Route::post('/image_upload_save', 'HomeCarouselController@image_upload_save')->name('image_upload_save');
        Route::post('/image_ordering', 'HomeCarouselController@image_ordering')->name('image_ordering');
        Route::post('/image_detail_modal', 'HomeCarouselController@image_detail_modal')->name('image_detail_modal');
        Route::post('/image_delete', 'HomeCarouselController@image_delete')->name('image_delete');
        Route::post('/save_image_details', 'HomeCarouselController@save_image_details')->name('save_image_details');
        Route::post('/image_list', 'HomeCarouselController@image_list')->name('image_list');
    });
       
    Route::group(['prefix' => '/film'], function () {
        Route::get('/', 'FilmController@index')->name('film');
        Route::post('/show_film_form', 'FilmController@show_film_form')->name('show_film_form');
        Route::post('/save_film', 'FilmController@save_film')->name('save_film');
        
    });
});