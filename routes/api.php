<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'ApiAuthenticationController@api_register');
Route::post('saveGalery', 'UserUpdateController@storeImagen');

Route::patch('updateDescripcion', 'UserUpdateController@updateDescripcion');
Route::post('updateOfertas', 'UserUpdateController@updateOfertas');
Route::post('updateContactos', 'UserUpdateController@updateContactos');
// Route::post('saveGalery', 'UserUpdateController@storeImagen');

Route::delete('deleteGalery/{id}', 'UserUpdateController@destroyImagen');
Route::get('user', 'ApiAuthenticationController@getUser');
Route::delete('logout', 'ApiAuthenticationController@logout');
Route::get('search/{search}', 'SearchController@searchJob');
Route::get('search_user/{id}', 'SearchController@searchJobUser');