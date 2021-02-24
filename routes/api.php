<?php

use Illuminate\Support\Facades\Route;

const BASE = '/v1/user/';
const ADMIN = '/v1/admin/';

Route::post(BASE . 'login', 'LoginController@Login');
// Route::post(BASE . 'createLab', 'CreateUserController@createLab');
// Route::post(BASE . 'createHospital', 'CreateUserController@createHospital');

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::get(BASE . 'checkUser', 'UserController@checkUser');

    Route::group(['middleware' => 'user'], function () { // Users middleware

        Route::get(BASE . 'search', 'SearchController@searchDoc');
        Route::get(BASE . 'searchLab', 'SearchController@searchLab');

        Route::post(BASE . 'reservDoc', 'ReservationsController@reservDoc');
        Route::post(BASE . 'reservLab', 'UserDiagnosisController@userDiagnosis');


        Route::get(BASE . 'prevReserv', 'UserController@previousReservation');
    });

    Route::group(['middleware' => 'systemUsers'], function () { // hospital and lab middleware
        // personal informations
        Route::get(BASE . 'Profile', 'UserController@profile');

        // update informations
        Route::put(BASE . 'updateProfile', 'UserController@updateProfile');
        Route::put(BASE . 'resetPassword', 'UserController@resetPassword');
        Route::get(BASE . 'forgetPassword', 'UserController@forgetPassword');

        Route::post(BASE . 'createDoctor', 'DoctorController@createDoctor');
        Route::post(BASE . 'createHospitalServices', 'ServicesController@create');

        Route::post(BASE . 'createLabDiagnosis', 'LabDiagnosisController@createLabDiagnosis');
        Route::post(BASE . 'createLabServices', 'LabServicesController@create');

        // accept client reservation request
        Route::put(BASE . 'hospital/reservation/accept', 'ReservationsController@acceptReservation');
        Route::put(BASE . 'lab/reservation/accept', 'UserDiagnosisController@acceptDiagnosis');

        // my doctors
        Route::get(BASE . 'hospital/hospitalDoctor', 'DoctorController@index');
        Route::put(BASE . 'hospital/hospitalDoctor/{docInfoID}', 'DocInfoController@update');
        Route::delete(BASE . 'hospital/hospitalDoctor/{id}', 'DocInfoController@delete');

        // my diagnosis

        // hospital side
        Route::put(BASE . 'update/docSchedule/{docScheduleID}', 'DocScheduleController@update');
        Route::put(BASE . 'update/docInfo/{docInfoID}', 'DocInfoController@update');
        Route::put(BASE . 'update/services/{serviceID}', 'ServicesController@update');
        Route::put(BASE . 'update/hospitalDoctors/{docID}', 'DoctorController@update');

        Route::get(BASE . 'docSchedule', 'DocScheduleController@index');
        Route::get(BASE . 'docInfo', 'DocInfoController@index');
        Route::get(BASE . 'hospitalServices', 'ServicesController@viewHospitalServices');
        Route::get(BASE . 'hospitalInvoice', 'HospitalInvoiceController@viewHospitalInvoice');
        Route::get(BASE . 'hospitalReservations', 'ReservationsController@viewHospitalReservations');
        Route::get(BASE . 'hospitalDoctors', 'DoctorController@viewHospitalDoctors');

        Route::delete(BASE . 'delete/docSchedule/{docScheduleID}', 'DocScheduleController@delete');
        Route::delete(BASE . 'delete/docInfo/{docInfoID}', 'DocInfoController@delete');
        Route::delete(BASE . 'delete/hospitalServices/{serviceID}', 'ServicesController@delete');
        Route::delete(BASE . 'delete/hospitalDoctors/{docID}', 'DoctorController@delete');

        // lab side
        Route::get(BASE . 'labDiagnosis', 'LabDiagnosisController@getLabDiagnosis');
        Route::get(BASE . 'labServices', 'LabServicesController@index');
        Route::get(BASE . 'labInvoice', 'InvoiceController@getLabInvoice');
        Route::get(BASE . 'labReservations', 'UserDiagnosisController@getLabReservations');

        Route::put(BASE . 'update/labDiagnosis/{LabDiagnosisID}', 'LabDiagnosisController@update');
        Route::put(BASE . 'update/labServices/{labServiceID}', 'LabServicesController@update');

        Route::delete(BASE . 'delete/labDiagnosis/{LabDiagnosisID}', 'LabDiagnosisController@delete');
        Route::delete(BASE . 'delete/labServices/{labServiceID}', 'LabServicesController@delete');

        // resources
        Route::resource(BASE . 'hospitalData', 'HospitalDataResourcesController')->except(['store', 'edit']);
        Route::resource(BASE . 'labData', 'LabDataResourcesController')->except(['store', 'edit']);
    });

    Route::group(['middleware' => 'adminUser'], function () { // admin route

        // resources
        Route::resource(ADMIN . 'hospitals', 'HospitalResourceController')->except(['store', 'edit']);
        Route::resource(ADMIN . 'doctors', 'DoctorResourceController')->only(['index', 'show', 'destroy']);
        Route::resource(ADMIN . 'labs', 'LabResourceController')->except(['store', 'edit']);
        Route::resource(ADMIN . 'settings', 'SettingsResourceController')->except(['store', 'edit']);

        // hospital reports
        Route::get(ADMIN . 'hospitalsInvoices', 'HospitalInvoiceController@view');
        Route::get(ADMIN . 'hospitalsInfos', 'HospitalInfoController@view');
        Route::get(ADMIN . 'hospitalsServices', 'HospitalServicesController@view');

        // lab reports
        Route::get(ADMIN . 'labsInvoices', 'InvoiceController@index');
        Route::get(ADMIN . 'labsInfos', 'LabDiagnosisController@index');
        Route::get(ADMIN . 'labsServices', 'ServicesController@index');

        // reservations
        Route::get(ADMIN . 'reservations', 'ReservationsController@index');
        Route::get(ADMIN . 'diagnosis', 'UserDiagnosisController@index');
    });
});
