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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('login', 'AuthController@login');
    });

    Route::group(['namespace' => 'Auth', 'middleware' => ['auth:api']], function () {
        Route::get('detail', 'AuthController@detail');
        Route::get('logout', 'AuthController@logout');
    });

    Route::group(['prefix' => 'master', 'namespace' => 'Master', 'middleware' => ['auth:api']], function () {
        // Master Rest Area
        Route::get('areas', 'AreaController@index');
        Route::get('areas/byUserId', 'AreaController@getByUserId');
        Route::get('areas/{id}', 'AreaController@show');

        // Master Kelompok Aset
        Route::get('asset-groups/all', 'AssetGroupController@all');

        // Master Aset
        Route::get('assets/byGroupAll/{id}', 'AssetController@getByGroupAll');

        // Master Matrik
        Route::get('matriks/byGroupAll/{id}', 'MatrikController@getByGroupAll');
    });

    Route::group(['prefix' => 'monitor', 'namespace' => 'Monitor', 'middleware' => ['auth:api']], function () {
        // Aset Performances
        Route::get('performances', 'AssetPerformanceController@index');
        Route::get('performances/asset-not-post', 'AssetPerformanceController@getAssetNotPost');
        Route::post('performances', 'AssetPerformanceController@store');
        Route::get('performances/{id}', 'AssetPerformanceController@show');
        Route::put('performances/{id}', 'AssetPerformanceController@update');
    });

    Route::group(['prefix' => 'monitor', 'namespace' => 'Monitor', 'middleware' => ['auth:api']], function () {
        Route::get('inspections', 'InspectionController@index');
        Route::post('inspections', 'InspectionController@store');
        Route::get('inspections/open', 'InspectionController@getAllInspectionOpen');
        Route::get('inspections/{id}', 'InspectionController@show');
        Route::patch('inspections/{id}', 'InspectionController@update');
        Route::post('inspections/follow-up/{id}', 'InspectionController@followUp');

        Route::get('complaints', 'ComplaintController@index');
        Route::post('complaints', 'ComplaintController@store');
        Route::get('complaints/{id}', 'ComplaintController@show');
        Route::put('complaints/{id}', 'ComplaintController@update');
        Route::post('complaints/follow-up/{id}', 'ComplaintController@followUp');
    });
});
