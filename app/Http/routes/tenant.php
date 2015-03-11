<?php
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here is where we register tenant (sub-domain) related routes
|
*/

    if(env('APP_ENV') == 'live')
    {
        $group_superadmin =['domain' => '{account}.mashbooks.no'];
        $group_guest = ['domain' => '{account}.mashbooks.no', 'middleware' => 'guest.tenant'];
        $group_auth = ['domain' => '{account}.mashbooks.no', 'middleware' => 'auth.tenant'];
    }
    elseif(env('APP_ENV') == 'dev')
    {
        $group_superadmin =['domain' => '{account}.mashbooks.app'];
        $group_guest = ['domain' => '{account}.mashbooks.app', 'middleware' => 'guest.tenant'];
        $group_auth = ['domain' => '{account}.mashbooks.app', 'middleware' => 'auth.tenant'];
    }
    else{
        $domain = env('MY_TENANT','manish_co');
        $group_superadmin =['prefix' => $domain];
        $group_guest = ['prefix' => $domain, 'middleware' => 'guest.tenant'];
        $group_auth =['prefix' => $domain, 'middleware' => ['auth.tenant']];
    }


    Route::group($group_superadmin, function ($account) {
        get('block/account', 'Tenant\AuthController@blockAccount');
    });


    Route::group($group_guest, function ($account) {
        get('login', ['as' => 'tenant.login', 'uses' => 'Tenant\AuthController@getLogin']);
        post('login', 'Tenant\AuthController@postLogin');
        post('register', ['as' => 'tenant.register', 'uses' => 'Tenant\AuthController@postRegister']);
        get('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'Tenant\RemindersController@forgetPassword']);
        post('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'Tenant\RemindersController@postForgotPassword']);
        get('reset-password/{code}', ['as' => 'tenant.resetPassword', 'uses' => 'Tenant\RemindersController@getReset']);
        post('reset-password/{code}', ['uses' => 'Tenant\RemindersController@postReset']);
        get('verify/{confirmationCode}', ['as' => 'subuser.register.confirm', 'uses' => 'Tenant\AuthController@confirm']);
    });


    Route::group($group_auth, function ($account) {
    	//registered by : Krita
        get('/', ['as' => 'tenant.index', 'uses' => 'Tenant\DashboardController@index']);
        get('/logout', ['as' => 'tenant.logout', 'uses' => 'Tenant\AuthController@logout']);
        get('setup/about', ['as' => 'tenant.setup.about', 'uses' => 'Tenant\SetupController@getAbout']);
        get('setup/business', ['as' => 'tenant.setup.business', 'uses' => 'Tenant\SetupController@getBusiness']);
        get('setup/fix', ['as' => 'tenant.setup.fix', 'uses' => 'Tenant\SetupController@getFix']);
        post('setup/about', ['as' => 'tenant.setup.save.about', 'uses' => 'Tenant\SetupController@saveAbout']);
        post('setup/business', ['as' => 'tenant.setup.save.business', 'uses' => 'Tenant\SetupController@saveBusiness']);
        post('setup/fix', ['as' => 'tenant.setup.save.fix', 'uses' => 'Tenant\SetupController@saveFix']);

		//get('setting/email', ['as' => 'tenant.setting.email', 'uses' => 'Tenant\SettingController@email']);
        get('setting/system', ['as' => 'tenant.setting.system', 'uses' => 'Tenant\Settings\SystemController@index']);
        post('setting/system', ['as' => 'tenant.setup.update', 'uses' => 'Tenant\Settings\SystemController@update']);
        post('setting/system/fixupdate', ['as' => 'tenant.setup.fixUpdate', 'uses' => 'Tenant\Settings\SystemController@saveFix']);
        get('setting/email', ['as' => 'tenant.setting.email', 'uses' => 'Tenant\Settings\EmailController@index']);
      	post('setting/email', ['as' => 'tenant.setting.email', 'uses' => 'Tenant\Settings\EmailController@update']);
        get('setting/user', ['as' => 'tenant.setting.user', 'uses' => 'Tenant\Settings\UserController@index']);
        post('setting/user', ['as' => 'tenant.setting.user', 'uses' => 'Tenant\Settings\UserController@update']);
        get('setting/template', ['as' => 'tenant.setting.template', 'uses' => 'Tenant\SettingController@template']);
        post('setting/update', ['as' => 'tenant.setting.update', 'uses' => 'Tenant\SettingController@update']);
        get('profile', ['as' => 'tenant.profile', 'uses' => 'Tenant\DashboardController@profile']);
        get('change-password', ['as' => 'tenant.auth.changePassword', 'uses' => 'Tenant\AuthController@changePassword']);
        post('change-password', ['as' => 'tenant.auth.postUserPasswordChange', 'uses' => 'Tenant\AuthController@postUserPasswordChange']);
        
		//registered by : Krita
        get('city/suggestions/{postalCode}', ['as' => 'tenant.zip.town', 'uses' => 'Tenant\SetupController@getZipTown']);
        get('postal/suggestions', ['as' => 'tenant.zip.postal', 'uses' => 'Tenant\SetupController@getPostalCode']);
        get('users', ['as' => 'tenant.users', 'uses' => 'Tenant\Users\UserController@index']);
        post('users/save', ['as' => 'tenant.user.save', 'uses' => 'Tenant\Users\UserController@saveUser']);
        get('customer', ['as' => 'tenant.customer', 'uses' => 'Tenant\CustomerController@index']);
        get('block/user/{guid}', ['as' => 'subuser.block', 'uses' => 'Tenant\Users\UserController@blockUser']);
        get('unblock/user/{guid}', ['as' => 'subuser.unblock', 'uses' => 'Tenant\Users\UserController@unblockUser']);
        get('delete/user/{guid}', ['as' => 'subuser.delete', 'uses' => 'Tenant\Users\UserController@deleteUser']);
        get('update/user/{guid}', ['as' => 'subuser.update', 'uses' => 'Tenant\Users\UserController@getUpdate']);
        post('update/user', ['as' => 'tenant.user.update', 'uses' => 'Tenant\Users\UserController@updateUser']);
        get('user/{guid}', ['as' => 'subuser.profile', 'uses' => 'Tenant\Users\UserController@profile']);
        post('user/data',['as'=>'tenant.user.data', 'uses'=>'Tenant\Users\UserController@dataJson']);

        //registered by : Manish


        // product routes
		get('inventory/product',['as'=>'tenant.inventory.product.index', 'uses'=>'Tenant\Inventory\ProductController@index']);
        post('inventory/product/data',['as'=>'tenant.inventory.product.data', 'uses'=>'Tenant\Inventory\ProductController@dataJson']);
        post('inventory/product',['as'=>'tenant.inventory.product.post', 'uses'=>'Tenant\Inventory\ProductController@create']);
        get('inventory/product/{id}',['as'=>'tenant.inventory.product.show', 'uses'=>'Tenant\Inventory\ProductController@show']);
        post('inventory/product/{id}/edit',['as'=>'tenant.inventory.product.update', 'uses'=>'Tenant\Inventory\ProductController@update']);
        get('inventory/product/{id}/edit',['as'=>'tenant.inventory.product.edit', 'uses'=>'Tenant\Inventory\ProductController@edit']);
        get('inventory/product/{id}/delete',['as'=>'tenant.inventory.product.delete', 'uses'=>'Tenant\Inventory\ProductController@delete']);


        // ineventory routes
        get('inventory',['as'=>'tenant.inventory.index', 'uses' => 'Tenant\Inventory\InventoryController@index']);
        post('inventory/data',['as'=>'tenant.inventory.data', 'uses'=>'Tenant\Inventory\InventoryController@dataJson']);
        post('inventory',['as'=>'tenant.inventory.post', 'uses'=>'Tenant\Inventory\InventoryController@create']);
        get('inventory/{id}',['as'=>'tenant.inventory.show', 'uses'=>'Tenant\Inventory\InventoryController@show']);
        post('inventory/{id}/edit',['as'=>'tenant.inventory.update', 'uses'=>'Tenant\Inventory\InventoryController@update']);
        get('inventory/{id}/edit',['as'=>'tenant.inventory.edit', 'uses'=>'Tenant\Inventory\InventoryController@edit']);
        get('inventory/{id}/delete',['as'=>'tenant.inventory.delete', 'uses'=>'Tenant\Inventory\InventoryController@delete']);



        //registered by : Pooja

		get('customer',['as'=>'tenant.customer.index', 'uses' => 'Tenant\Customer\CustomerController@index']);
		post('customer',['as'=>'tenant.customer.create', 'uses' => 'Tenant\Customer\CustomerController@create']);
        get('customer/CustomerCard/{id}',['as'=>'tenant.customer.CustomerCard', 'uses' => 'Tenant\Customer\CustomerController@customerCard']);
        get('customer/delete/{id}', ['as' => 'customer.delete', 'uses' => 'Tenant\Customer\CustomerController@deleteCustomer']);
        get('customer/{id}/edit',['as'=>'tenant.customer.edit', 'uses'=>'Tenant\Customer\CustomerController@edit']);
        post('customer/{id}/edit',['as'=>'tenant.customer.edit', 'uses'=>'Tenant\Customer\CustomerController@update']);
        post('customer/data',['as'=>'tenant.customer.data', 'uses'=>'Tenant\Customer\CustomerController@dataJson']);
        post('customer/upload',['as'=>'tenant.customer.upload', 'uses'=>'Tenant\Customer\CustomerController@upload']);

        // Krita
        post('test/upload', ['as' => 'test.upload', 'uses' => 'Tenant\Customer\CustomerController@testUpload']);
    });
