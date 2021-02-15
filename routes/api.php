<?php

use Illuminate\Support\Facades\Route;

const BASE = '/v1/user/';

Route::post(BASE . 'login', 'LoginController@Login');
Route::post(BASE . 'createLab', 'CreateUserController@createLab');
Route::post(BASE . 'createHospital', 'CreateUserController@createHospital');

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::group(['middleware' => 'user'], function () { // Users middleware

        Route::get(BASE . 'search', 'SearchController@searchDoc');
        Route::get(BASE . 'searchLab', 'SearchController@searchLab');

        Route::post(BASE . 'reservDoc', 'ReservationsController@reservDoc');
        Route::post(BASE . 'reservLab', 'UserDiagnosisController@userDiagnosis');


        Route::get(BASE . 'prevReserv', 'UserController@previousReservation');
    });

    Route::group(['middleware' => 'systemUsers'], function () { // hospital , lab middleware

        Route::post(BASE . 'createDoctor', 'DoctorController@createDoctor');

        // update informations
        Route::put(BASE . 'updateProfile', 'UserController@updateProfile');
        Route::put(BASE . 'resetPassword', 'UserController@resetPassword');
        Route::get(BASE . 'forgetPassword', 'UserController@forgetPassword');
    });
});
