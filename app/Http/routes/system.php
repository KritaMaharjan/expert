<?php
/*
|--------------------------------------------------------------------------
| Master Admin Routes
|--------------------------------------------------------------------------
|
| Here is where we register super-admin panel routes
|
*/

Route::group(['prefix' => 'system', 'middleware' => ['preventSystem','guest.system']], function () {
    get('login', ['as' => 'system.login', 'uses' => 'System\AuthController@getLogin']);
    post('login', 'System\AuthController@postLogin');
    get('forgot-password', ['as' => 'system.reminders.getRemind', 'uses' => 'System\RemindersController@getForgotPassword']);
    post('forgot-password', ['as' => 'system.reminders.getRemind', 'uses' => 'System\RemindersController@postForgotPassword']);
    get('reset-password/{code}', ['as' => 'system.reminders.getReset', 'uses' => 'System\RemindersController@getReset']);
    post('reset-password', ['as' => 'system.reminders.postReset', 'uses' => 'System\RemindersController@postReset']);
});


Route::group(['prefix' => 'system', 'middleware' => ['preventSystem','auth.system']], function () {
    get('/', ['as' => 'system.index', 'uses' => 'System\DashboardController@index']);
    get('logout', ['as' => 'system.logout', 'uses' => 'System\AuthController@logout']);
    get('setting/email', ['as' => 'system.setting.email', 'uses' => 'System\SettingController@email']);
    get('setting/template', ['as' => 'system.setting.template', 'uses' => 'System\SettingController@template']);
    post('setting/update', ['as' => 'system.setting.update', 'uses' => 'System\SettingController@update']);
    get('client', ['as' => 'system.user', 'uses' => 'System\ClientController@index']);
    get('client/{id}', ['as' => 'system.user.show', 'uses' => 'System\ClientController@show']);
    get('profile', ['as' => 'system.user.profile', 'uses' => 'System\ClientController@profile']);
    get('change-password', ['as' => 'system.auth.changePassword', 'uses' => 'System\AuthController@changePassword']);
    post('change-password', ['as' => 'system.auth.postUserPasswordChange', 'uses' => 'System\AuthController@postUserPasswordChange']);
    get('block', ['as' => 'system.client.block', 'uses' => 'System\ClientController@block']);
    post('client/data',['as'=>'system.client.data', 'uses'=>'System\ClientController@dataJson']);
});