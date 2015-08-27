<?php
/*
|--------------------------------------------------------------------------
| Master Admin Routes
|--------------------------------------------------------------------------
|
| Here is where we register super-admin panel routes
|
*/
//Route::group(['namespace'=>'Controllers'], function(){
Route::get('/', ['as' => 'system.login', 'uses' => 'System\AuthController@getLogin']);
Route::group(['prefix' => 'system', 'middleware' => ['preventSystem','guest.system']], function () {
    get('login', ['as' => 'system.login', 'uses' => 'System\AuthController@getLogin']);
    post('login', 'System\AuthController@postLogin');
    get('forgot-password', ['as' => 'system.reminders.getRemind', 'uses' => 'System\RemindersController@getForgotPassword']);
    post('forgot-password', ['as' => 'system.reminders.getRemind', 'uses' => 'System\RemindersController@postForgotPassword']);
    get('reset-password/{code}', ['as' => 'system.reminders.getReset', 'uses' => 'System\RemindersController@getReset']);
    post('reset-password/{code}', ['as' => 'system.reminders.postReset', 'uses' => 'System\RemindersController@postReset']);
});


Route::group(['prefix' => 'system', 'middleware' => ['preventSystem','auth.system']], function () {
    get('/', ['as' => 'system.index', 'uses' => 'System\DashboardController@index']);
    post('data',['as'=>'system.dashboard.data', 'uses'=>'System\DashboardController@dataJson']);

    get('logout', ['as' => 'system.logout', 'uses' => 'System\AuthController@logout']);
    get('setting/email', ['as' => 'system.setting.email', 'uses' => 'System\SettingController@email']);
    get('setting/template', ['as' => 'system.setting.template', 'uses' => 'System\SettingController@template']);
    post('setting/template', ['as' => 'system.template.save', 'uses' => 'System\SettingController@updateTemplate']);
    post('setting/update', ['as' => 'system.setting.update', 'uses' => 'System\SettingController@update']);

    /* Client routes */
    get('client', ['as' => 'system.client', 'uses' => 'System\ClientController@index']);
    //get('client/{id}', ['as' => 'system.user.show', 'uses' => 'System\ClientController@show']);
    get('client/add', ['as' => 'system.client.add', 'uses' => 'System\ClientController@add']);
    post('client/add', ['as' => 'system.client.create', 'uses' => 'System\ClientController@create']);
    get('client/edit/{id}', ['as' => 'system.client.edit', 'uses' => 'System\ClientController@edit']);
    post('client/edit/{id}', ['as' => 'system.client.update', 'uses' => 'System\ClientController@update']);
    get('client/delete/{id}', ['as' => 'system.client.delete', 'uses' => 'System\ClientController@delete']);
    post('client/data',['as'=>'system.client.data', 'uses'=>'System\ClientController@dataJson']);

    /* Lead routes */
    get('lead', ['as' => 'system.lead', 'uses' => 'System\LeadController@index']);
    get('lead/accepted', ['as' => 'system.lead.accepted', 'uses' => 'System\LeadController@accepted']);
    get('lead/add', ['as' => 'system.lead.add', 'uses' => 'System\LeadController@add']);
    post('lead/add', ['as' => 'system.lead.create', 'uses' => 'System\LeadController@create']);
    get('lead/view/{id}', ['as' => 'system.lead.view', 'uses' => 'System\LeadController@view']);
    get('lead/edit/{id}', ['as' => 'system.lead.edit', 'uses' => 'System\LeadController@edit']);
    post('lead/edit/{id}', ['as' => 'system.lead.update', 'uses' => 'System\LeadController@update']);
    get('lead/delete/{id}', ['as' => 'system.lead.delete', 'uses' => 'System\LeadController@delete']);
    get('lead/log/delete/{id}', ['as' => 'system.lead.log.delete', 'uses' => 'System\LeadController@deleteLog']);
    get('lead/assign/{id}', ['as' => 'system.lead.assign', 'uses' => 'System\LeadController@assign']);
    post('lead/assign/{id}', ['as' => 'system.lead.assign', 'uses' => 'System\LeadController@postAssign']);
    get('lead/log/{id}', ['as' => 'system.lead.log', 'uses' => 'System\LeadController@log']);
    post('lead/log/{id}', ['as' => 'system.lead.log', 'uses' => 'System\LeadController@postLog']);
    get('lead/accept/{id}', ['as' => 'system.lead.accept', 'uses' => 'System\LeadController@accept']);
    post('lead/data',['as'=>'system.lead.data', 'uses'=>'System\LeadController@dataJson']);
    post('lead/accepted/data',['as'=>'system.lead.data.accepted', 'uses'=>'System\LeadController@acceptedDataJson']);
    get('lead/pending',['as'=>'system.lead.pending', 'uses'=>'System\LeadController@pending']);

    /* Application routes */
    get('application', ['as' => 'system.application', 'uses' => 'System\ApplicationController@index']);
    get('application/add/{id}', ['as' => 'system.application.add', 'uses' => 'System\ApplicationController@add']);
    post('application/add/{id}', ['as' => 'system.application.create', 'uses' => 'System\ApplicationController@create']);

    get('application/property/{id}', ['as' => 'system.application.property', 'uses' => 'System\PropertyController@add']);
    post('application/property/{id}', ['as' => 'system.application.createProperty', 'uses' => 'System\PropertyController@create']);

    get('application/other/{id}', ['as' => 'system.application.other', 'uses' => 'System\OtherController@add']);
    post('application/other/{id}', ['as' => 'system.application.createOther', 'uses' => 'System\OtherController@create']);

    get('application/income/{id}', ['as' => 'system.application.income', 'uses' => 'System\IncomeController@add']);
    post('application/income/{id}', ['as' => 'system.application.createIncome', 'uses' => 'System\IncomeController@create']);

    get('application/expense/{id}', ['as' => 'system.application.expense', 'uses' => 'System\ExpenseController@add']);
    post('application/expense/{id}', ['as' => 'system.application.createExpense', 'uses' => 'System\ExpenseController@create']);

    get('application/review/{id}', ['as' => 'system.application.review', 'uses' => 'System\ReviewController@index']);

    get('application/view/{id}', ['as' => 'system.application.view', 'uses' => 'System\ApplicationController@view']);
    get('application/edit/{id}', ['as' => 'system.application.edit', 'uses' => 'System\ApplicationController@edit']);
    post('application/edit/{id}', ['as' => 'system.application.update', 'uses' => 'System\ApplicationController@update']);
    get('application/delete/{id}', ['as' => 'system.application.delete', 'uses' => 'System\ApplicationController@delete']);
    get('application/log/delete/{id}', ['as' => 'system.application.log.delete', 'uses' => 'System\ApplicationController@deleteLog']);
    get('application/assign/{id}', ['as' => 'system.application.assign', 'uses' => 'System\ApplicationController@assign']);
    post('application/assign/{id}', ['as' => 'system.application.assign', 'uses' => 'System\ApplicationController@postAssign']);
    get('application/log/{id}', ['as' => 'system.application.log', 'uses' => 'System\ApplicationController@log']);
    post('application/log/{id}', ['as' => 'system.application.log', 'uses' => 'System\ApplicationController@postLog']);
    get('application/accept/{id}', ['as' => 'system.application.accept', 'uses' => 'System\ApplicationController@accept']);
    post('application/data',['as'=>'system.application.data', 'uses'=>'System\ApplicationController@dataJson']);

    get('profile', ['as' => 'system.user.profile', 'uses' => 'System\UserController@profile']);
    get('change-password', ['as' => 'system.auth.changePassword', 'uses' => 'System\AuthController@changePassword']);
    post('change-password', ['as' => 'system.auth.postUserPasswordChange', 'uses' => 'System\AuthController@postUserPasswordChange']);
    get('block', ['as' => 'system.client.block', 'uses' => 'System\ClientController@block']);

    /* User routes */
    get('user', ['as' => 'system.user', 'uses' => 'System\UserController@index']);
    get('user/add', ['as' => 'system.user.add', 'uses' => 'System\UserController@add']);
    post('user/add', ['as' => 'system.user.create', 'uses' => 'System\UserController@create']);
    get('user/edit/{id}', ['as' => 'system.user.edit', 'uses' => 'System\UserController@edit']);
    post('user/edit/{id}', ['as' => 'system.user.update', 'uses' => 'System\UserController@update']);
    get('user/delete/{id}', ['as' => 'system.user.delete', 'uses' => 'System\UserController@delete']);
    post('user/data',['as'=>'system.user.data', 'uses'=>'System\UserController@dataJson']);

    /* Report routes */
    get('report', ['as' => 'system.report', 'uses' => 'System\ReportController@index']);
    post('report/data',['as'=>'system.report.data', 'uses'=>'System\ReportController@dataJson']);
});

//});
