<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->group(function(){
    Route::get('/user', function (Request $request){
        return $request->user();
    });
    Route::get('evidencijas', 'EvidencijaController@index');
    Route::group(['prefix' => 'evidencija'], function () {
        Route::post('store', 'EvidencijaController@store');
        Route::get('statistika', 'EvidencijaController@statistika');
        Route::get('edit/{id}', 'EvidencijaController@edit');
        Route::post('update/{id}', 'EvidencijaController@update');
        Route::delete('destroy/{id}', 'EvidencijaController@destroy');
    });

    Route::get('kalendars/{datum}', 'KalendarController@index');
    Route::group(['prefix' => 'kalendar'], function () {
        Route::post('store', 'KalendarController@store');
        Route::get('master_all/{id}', 'KalendarController@getDetails');
        Route::get('edit/{id}', 'KalendarController@edit');
        Route::post('update/{id}', 'KalendarController@update');
        Route::delete('destroy/{id}', 'KalendarController@destroy');
    });

    Route::get('mjestas', 'MjestaController@index');
    Route::group(['prefix' => 'mjesta'], function () {
        Route::post('store', 'MjestaController@store');
        Route::get('edit/{id}', 'MjestaController@edit');
        Route::post('update/{id}', 'MjestaController@update');
        Route::delete('destroy/{id}', 'MjestaController@destroy');
    });

    Route::get('poveznicas', 'PoveznicaController@index');
    Route::group(['prefix' => 'poveznica'], function () {
        Route::post('store', 'PoveznicaController@store');
        Route::get('master_all/{id}', 'PoveznicaController@getDetails');
        Route::get('edit/{id}', 'PoveznicaController@edit');
        Route::post('update/{id}', 'PoveznicaController@update');
        Route::delete('destroy/{id}', 'PoveznicaController@destroy');
    });

    Route::get('skladistes', 'SkladisteController@index');
    Route::group(['prefix' => 'skladiste'], function () {
        Route::post('store', 'SkladisteController@store');
        Route::get('statistika', 'SkladisteController@statistika');
        Route::get('check/{id}/{kolicina}', 'SkladisteController@check');
        Route::get('show/{id}', 'SkladisteController@show');
        Route::get('edit/{id}', 'SkladisteController@edit');
        Route::post('update/{id}', 'SkladisteController@update');
        Route::delete('destroy/{id}', 'SkladisteController@destroy');
    });
});


Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');

