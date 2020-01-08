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

Route::get(null, 'HomeController@index')->name('home');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', 'UserController@index')->name('index')->middleware('perm:view-users.view-own-users.create-users');
    Route::get('create', 'UserController@create')->name('create')->middleware('perm:create-users');
    Route::post('store', 'UserController@store')->name('store')->middleware('perm:create-users');
    Route::get('remove/{user}', 'UserController@remove')->name('remove')->middleware('perm:delete-users');
    Route::get('edit/{user}', 'UserController@edit')->name('edit')->middleware('perm:edit-users.password-change');
    Route::post('update/{user}', 'UserController@update')->name('update')->middleware('perm:edit-users.password-change');
});

Route::prefix('roles')->name('roles.')->group(function () {
    Route::get('/', 'RoleController@index')->name('index')->middleware('perm:view-roles.create-roles');
    Route::get('create', 'RoleController@create')->name('create')->middleware('perm:create-roles');
    Route::post('store', 'RoleController@store')->name('store')->middleware('perm:create-roles');
    Route::get('remove/{role}', 'RoleController@remove')->name('remove')->middleware('perm:delete-roles');
    Route::get('edit/{role}', 'RoleController@edit')->name('edit')->middleware('perm:edit-roles');
    Route::post('update/{role}', 'RoleController@update')->name('update')->middleware('perm:edit-roles');
});

Route::prefix('clients')->name('clients.')->group(function () {
    Route::get('/', 'ClientController@index')->name('index')->middleware('perm:view-clients.create-clients');
    Route::get('create', 'ClientController@create')->name('create')->middleware('perm:create-clients');
    Route::post('store', 'ClientController@store')->name('store')->middleware('perm:create-clients');
    Route::get('remove/{client}', 'ClientController@remove')->name('remove')->middleware('perm:delete-clients');
    Route::get('edit/{client}', 'ClientController@edit')->name('edit')->middleware('perm:edit-clients');
    Route::post('update/{client}', 'ClientController@update')->name('update')->middleware('perm:edit-clients');
});

Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('/', 'PaymentController@index')->name('index')->middleware('perm:view-payments');
    Route::get('remove/{payment}', 'PaymentController@remove')->name('remove')->middleware('perm:delete-payments');
});
