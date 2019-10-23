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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['dashboard-admin', 'permission:read-dashboard-admin']], function () {
        Route::get('/', 'Home\AdminController@index');

        Route::group(['prefix' => 'master', 'namespace' => 'Masters'], function () {
            Route::resource('regions', 'RegionsController');
            Route::get('regions_data', 'RegionsController@datatables');
            Route::resource('ruas', 'RuasController');
            Route::get('ruas_data', 'RuasController@datatables');
            Route::resource('areas', 'AreasController');
            Route::get('areas_data', 'AreasController@datatables');
            Route::post('areas/ruas-dropdown', 'AreasController@ruasDropdown');
            Route::resource('asset_groups', 'AssetGroupsController');
            Route::get('asset_groups_data', 'AssetGroupsController@datatables');
            Route::resource('asset_kinds', 'AssetKindsController');
            Route::get('asset_kinds_data', 'AssetKindsController@datatables');
            Route::resource('asset_types', 'AssetTypesController');
            Route::get('asset_types_data', 'AssetTypesController@datatables');
            Route::resource('assets', 'AssetsController');
            Route::get('assets_data', 'AssetsController@datatables');
            Route::post('assets/dropdown', 'AssetsController@chained');
            Route::resource('matriks', 'MatriksController');
            Route::get('matriks_data', 'MatriksController@datatables');
        });

        Route::group(['prefix' => 'monitor', 'namespace' => 'Monitors'], function () {
            Route::resource('performances', 'AssetPerformanceController');
            Route::get('performances_data', 'AssetPerformanceController@datatables');
            Route::post('performances_print', 'AssetPerformanceController@printTable');
            Route::resource('inspections', 'InspectionController');
            Route::get('inspections_data', 'InspectionController@datatables');
            Route::post('inspections_print', 'InspectionController@export');
            Route::resource('complaints', 'ComplaintController');
            Route::get('complaints_data', 'ComplaintController@datatables');
            Route::post('complaints_print', 'ComplaintController@printTable');
        });

        Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
            Route::resource('roles', 'RoleController');
            Route::get('roles_data', 'RoleController@datatables');
            Route::resource('permissions', 'PermissionController');
            Route::get('permissions_data', 'PermissionController@datatables');
            Route::resource('users', 'UserController');
            Route::get('users_data', 'UserController@datatables');
        });
    });
});
