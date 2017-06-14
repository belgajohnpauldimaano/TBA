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

use Illuminate\Http\Request;

// Route::get('/', function () {
//         return redirect('cms/carousel');
// })->name('index');
Route::get('/gen', function () {
    
    $t=time();
    echo($t . "<br>");
    echo(date("Y-m-d",$t));
});
Route::get('/sample_upload_view', 'Frontend\FilmController@sample')->name('sample');

Route::post('/sample_upload', 'FilmController@sample_upload');

Auth::routes();

Route::get('/', 'Frontend\FilmController@home')->name('home');

Route::get('/films', 'Frontend\FilmController@films')->name('films');

Route::get('/about', 'Frontend\FilmController@about')->name('about');

Route::get('/contact', 'Frontend\FilmController@contact')->name('contact');

Route::get('/film/info', 'Frontend\FilmController@film_info')->name('film_info');

Route::get('/trailers', 'Frontend\FilmController@trailers')->name('trailers');

Route::get('/on-dvd', 'Frontend\FilmController@on_dvd')->name('on_dvd');

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => '/cms'], function () {

    Route::group(['prefix' => '/carousel'], function () {
        Route::get('/home_page_carousel', 'HomeCarouselController@index')->name('home_page_carousel');
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
        Route::post('/film_synopsis_save', 'FilmController@film_synopsis_save')->name('film_synopsis_save');
        
        Route::get('/{id}', 'FilmController@specific_film_index')->name('specific_film_index');
        Route::group(['prefix' => '/trailer'], function () {
            Route::post('/trailer_order_save', 'FilmController@trailer_order_save')->name('trailer_order_save');
            Route::post('/show_hide_toggle', 'FilmController@show_hide_toggle')->name('show_hide_toggle');
            Route::post('/delete_trailer', 'FilmController@delete_trailer')->name('delete_trailer');
            Route::post('/film_trailer_fetch_record/{id}', 'FilmController@film_trailer_fetch_record')->name('film_trailer_fetch_record');
            Route::post('/film_trailer_form_modal', 'FilmController@film_trailer_form_modal')->name('film_trailer_form_modal');
            Route::post('/save_trailer/{id}', 'FilmController@save_trailer')->name('save_trailer');
            Route::post('/film_basic_info_fetch/{id}', 'FilmController@film_basic_info_fetch')->name('film_basic_info_fetch');
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

        Route::group(['prefix' => '/awards'], function () {
            Route::post('/film_award_order_save', 'FilmController@film_award_order_save')->name('film_award_order_save');
            Route::post('/film_award_form', 'FilmController@film_award_form')->name('film_award_form');
            Route::post('/film_awards_fetch/{id}', 'FilmController@film_awards_fetch')->name('film_awards_fetch');
            Route::post('/film_award_save/{id}', 'FilmController@film_award_save')->name('film_award_save');
            Route::post('/film_award_delete', 'FilmController@film_award_delete')->name('film_award_delete');
            
        });
        Route::group(['prefix' => '/photo'], function () {
            Route::post('/film_photo_fetch/{id}', 'FilmController@film_photo_fetch')->name('film_photo_fetch');
            Route::post('/film_photo_single_upload_form_modal', 'FilmController@film_photo_single_upload_form_modal')->name('film_photo_single_upload_form_modal');
            Route::post('/film_photo_single_save/{id}', 'FilmController@film_photo_single_save')->name('film_photo_single_save');
            Route::post('/film_photo_order_save', 'FilmController@film_photo_order_save')->name('film_photo_order_save');
            Route::post('/photo_single_delete', 'FilmController@photo_single_delete')->name('photo_single_delete');
            
        });
        
        Route::group(['prefix' => '/quote'], function () {
            Route::post('/film_quote_form_modal', 'FilmController@film_quote_form_modal')->name('film_quote_form_modal');
            Route::post('/film_quote_save', 'FilmController@film_quote_save')->name('film_quote_save');
            Route::post('/film_quote_fetch/{id}', 'FilmController@film_quote_fetch')->name('film_quote_fetch');
            
        });
        Route::group(['prefix' => '/press_release'], function () {
            Route::post('/film_press_release_form_modal/{id}', 'FilmController@film_press_release_form_modal')->name('film_press_release_form_modal');
            Route::post('/film_press_release_save', 'FilmController@film_press_release_save')->name('film_press_release_save');
            Route::post('/film_press_release_fetch/{id}', 'FilmController@film_press_release_fetch')->name('film_press_release_fetch');
            Route::post('/film_press_release_delete', 'FilmController@film_press_release_delete')->name('film_press_release_delete');
            
        });
        Route::group(['prefix' => '/film_crew'], function () {
            Route::post('/film_crew_form_modal', 'FilmController@film_crew_form_modal')->name('film_crew_form_modal');
            Route::post('/film_crew_save', 'FilmController@film_crew_save')->name('film_crew_save');
            Route::post('/film_crew_data_fetch/{id}', 'FilmController@film_crew_data_fetch')->name('film_crew_data_fetch');
            
        });
    });
});