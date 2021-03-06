<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Http\Request;

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
Auth::routes();



Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['auth']], function () {

    Route::resource('/observations', 'ObservationController');
    Route::get('/observations/{observations}/destroy', 'ObservationController@destroy');
    Route::get('/observations/{id}/fetch_image', 'ObservationController@fetch_image');

    Route::resource('/users','UserController');
    Route::get('/users/{user}/delete',['as'=>'users.delete','uses'=>'UserController@delete']);
    Route::get('/search',['as'=>'users.search','uses'=>'UserController@search']);


    /**
     * Web based interfaces to clear caches. Usually used for development purposes.
     * May help when deploying new version of application
     */

    //Clear route cache:
    Route::get('/clear-route', function () {
        $exitCode = Artisan::call('route:clear');
        return 'Routes cache cleared';
    });

    //Clear config cache:
    Route::get('/config-cache', function () {
        $exitCode = Artisan::call('config:clear');
        return 'Config cache cleared';
    });

    // Clear application cache:
    Route::get('/clear-cache', function () {
        $exitCode = Artisan::call('cache:clear');
        return 'Application cache cleared';
    });

    // Clear view cache:
    Route::get('/view-clear', function () {
        $exitCode = Artisan::call('view:clear');
        return 'View cache cleared';
    });

    // Clear all caches:
    Route::get('/clear-all', function () {
        $exitCode[] = Artisan::call('route:clear');
        $exitCode[] = Artisan::call('config:clear');
        $exitCode[] = Artisan::call('view:clear');
        $exitCode[] = Artisan::call('cache:clear');
        return 'All caches cleared';
    });
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


