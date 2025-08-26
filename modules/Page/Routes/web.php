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
use Illuminate\Support\Facades\Route;

// Page
Route::group(['prefix'=>config('page.page_route_prefix')],function(){
    Route::get('/{slug?}','PageController@detail')->name('page.detail');// Detail
});


// Page
Route::group(['prefix'=>config('page.custom_route_prefix')],function(){
    Route::get('/quiz', 'PageController@quiz')->name('page.quiz');
    Route::post('/share-stories', 'MediaController@shareStories')->name('quiz.share_stories');
});