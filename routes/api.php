<?php

use Illuminate\Support\Facades\Route;

const BASE = '/v1/user/';

Route::post(BASE . 'login', 'LoginController@Login');
Route::post(BASE . 'createLab', 'CreateUserController@createLab');
Route::post(BASE . 'createHospital', 'CreateUserController@createHospital');

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::get(BASE . 'login', 'UserController@login');

    Route::get(BASE . 'search', 'SearchController@searchDoc');
    Route::get(BASE . 'searchLab', 'SearchController@searchLab');

    Route::post(BASE . 'reservDoc', 'ReservationsController@reservDoc');
    Route::post(BASE . 'reservLab', 'UserDiagnosisController@userDiagnosis');

    Route::post(BASE . 'createDoctor', 'DoctorController@createDoctor');

    Route::post(BASE . 'updateProfile', 'UserController@updateProfile');
});
