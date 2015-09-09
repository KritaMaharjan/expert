<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| Here is where we register frontend routes and super-admin routes
|
*/
Route::group(["namespace"=>"Controllers"], function () {

    get('/', 'Frontend\PageController@home');
    get('register', 'Frontend\AuthController@getRegister');
    get('registration/success', 'Frontend\AuthController@getSuccess');
    get('domain/suggestion/{name}', 'Frontend\AuthController@getDomainSuggestion');
    post('register', ['as' => 'register', 'uses' => 'Frontend\AuthController@postRegister']);
    get('account/verify/{confirmationCode}', ['as' => 'frontend.register.confirm', 'uses' => 'Frontend\AuthController@confirm']);

    /*
     * Routes for static pages
     */
    get('features', ['as' => 'features', 'uses' => 'Frontend\PageController@features']);
    get('contact', ['as' => 'contact', 'uses' => 'Frontend\PageController@contact']);
    get('about', ['as' => 'about', 'uses' => 'Frontend\PageController@about']);
    get('login', ['as' => 'login', 'uses' => 'Frontend\AuthController@login']);
    post('login', ['as' => 'send.request.url', 'uses' => 'Frontend\AuthController@sendRequestUrl']);
});