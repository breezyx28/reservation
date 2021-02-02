<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

const BASE = '/v1/user/';
Route::get(BASE . 'home', 'HomeController@home');
Route::post(BASE . 'createLab', 'CreateUserController@createLab');
Route::post(BASE . 'createHospital', 'CreateUserController@createHospital');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get(BASE . 'login', 'UserController@login');

    Route::get(BASE . 'search', 'SearchController@searchDoc');
    Route::get(BASE . 'searchLab', 'SearchController@searchLab');

    Route::post(BASE . 'reservDoc', 'ReservationsController@reservDoc');
    Route::post(BASE . 'reservLab', 'UserDiagnosisController@userDiagnosis');

    Route::post(BASE . 'updateProfile', 'UserController@updateProfile');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
