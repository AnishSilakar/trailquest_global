<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
 use Illuminate\Support\Facades\Artisan;
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


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    
    return response()->json(['message' => 'Cache, config, view, and route caches cleared!']);
});

Route::get('/clear-config', function() {
    Artisan::call('config:clear');
    
    return response()->json(['message' => 'Config cache cleared!']);
});

Route::get('/clear-views', function() {
    Artisan::call('view:clear');
    
    return response()->json(['message' => 'View cache cleared!']);
});
  Route::get('/', 'HomeController@index')->name('home');
// Route::get('/home', 'HomeController@index')->name('home');
 
// Social Login
Route::get('social-login/{provider}', 'Auth\LoginController@socialLogin');
Route::get('social-callback/{provider}', 'Auth\LoginController@socialCallBack');

// Logs
Route::get(config('admin.admin_route_prefix').'/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware(['auth', 'dashboard','system_log_view'])->name('admin.logs');
 