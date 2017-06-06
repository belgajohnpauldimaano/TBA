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
        return redirect('cms/carousel');
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
        Route::post('/fetch_record', 'FilmController@fetch_record')->name('film_fetch_record');
        Route::post('/delete_film', 'FilmController@delete_film')->name('delete_film');
        

        Route::get('/{id}', 'FilmController@specific_film_index')->name('specific_film_index');
        Route::group(['prefix' => '/trailer'], function () {
            Route::post('/trailer_order_save', 'FilmController@trailer_order_save')->name('trailer_order_save');
            Route::post('/show_hide_toggle', 'FilmController@show_hide_toggle')->name('show_hide_toggle');
            Route::post('/delete_trailer', 'FilmController@delete_trailer')->name('delete_trailer');
            Route::post('/film_trailer_fetch_record/{id}', 'FilmController@film_trailer_fetch_record')->name('film_trailer_fetch_record');
            Route::post('/film_trailer_form_modal', 'FilmController@film_trailer_form_modal')->name('film_trailer_form_modal');
            Route::post('/save_trailer/{id}', 'FilmController@save_trailer')->name('save_trailer');
            
        });
        
        Route::group(['prefix' => '/poster'], function () {
            //Route::get('/poster', 'FilmController@film_poster')->name('film_poster');
            Route::post('/set_featured_image', 'FilmController@set_featured_image')->name('set_featured_image');
            Route::post('/posters_order_save', 'FilmController@posters_order_save')->name('posters_order_save');
            Route::post('/poster_image_modal', 'FilmController@poster_image_modal')->name('poster_image_modal');
            Route::post('/poster_image_upload', 'FilmController@poster_image_upload')->name('poster_image_upload');
            Route::post('/poster_image_delete', 'FilmController@poster_image_delete')->name('poster_image_delete');
            Route::post('/poster_image_fetch', 'FilmController@poster_image_fetch')->name('poster_image_fetch');
            
        });
    });
});