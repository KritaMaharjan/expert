<?php

Route::group($group_guest, function () {
    get('login', ['as' => 'tenant.login', 'uses' => 'Tenant\AuthController@getLogin']);
    post('login', 'Tenant\AuthController@postLogin');
    post('register', ['as' => 'tenant.register', 'uses' => 'Tenant\AuthController@postRegister']);
    get('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'Tenant\RemindersController@forgetPassword']);
    post('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'Tenant\RemindersController@postForgotPassword']);
    get('reset-password/{code}', ['as' => 'tenant.resetPassword', 'uses' => 'Tenant\RemindersController@getReset']);
    post('reset-password/{code}', ['uses' => 'Tenant\RemindersController@postReset']);
    get('verify/{confirmationCode}', ['as' => 'subuser.register.confirm', 'uses' => 'Tenant\AuthController@confirm']);
});


Route::group($group_auth, function () {
    /*
     * New Modular Routing
     */

    Route::group(['prefix' => 'file', 'namespace' => 'Tenant\File\Controllers'], function () {
        post('upload/data', 'FileController@upload');
        get('delete', 'FileController@delete');
    });

    Route::group(['prefix' => 'desk', 'namespace' => 'Tenant\Email\Controllers'], function () {
        get('email', ['as' => 'desk.email', 'uses' => 'EmailController@index']);
        post('email/send', ['as' => 'desk.email.send', 'uses' => 'EmailController@send']);
        get('email/customer/search', ['as' => 'tenant.email.customer.search', 'uses' => 'EmailController@customerSearch']);
        get('email/{id}/delete', ['as' => 'tenant.email.delete', 'uses' => 'EmailController@delete']);
        get('email/{id}/reply', ['as' => 'tenant.email.reply', 'uses' => 'EmailController@reply']);
        get('email/{id}/forward', ['as' => 'tenant.email.forward', 'uses' => 'EmailController@forward']);
        get('email/list', ['as' => 'tenant.email.forward', 'uses' => 'EmailController@listing']);
        get('email/{id}/show', ['as' => 'tenant.email.show', 'uses' => 'EmailController@show']);
        get('email/{id}/get', ['as' => 'tenant.email.get', 'uses' => 'EmailController@get']);
        get('email/search_emails', ['as' => 'tenant.email.search', 'uses' => 'EmailController@search_email']);
        get('email/inbox', ['as' => 'tenant.email.inbox', 'uses' => 'IncomingEmailController@inbox']);
    });

    // Registered by Krita
    Route::group(['namespace' => 'Tenant\Statistics\Controllers'], function () {
        get('statistics', ['as' => 'tenant.statistics', 'uses' => 'StatisticsController@index']);
        get('statistics/graph', ['as' => 'tenant.statistics.graph', 'uses' => 'StatisticsController@graph']);
    });

    // Registered by Krita
    Route::group(['namespace' => 'Tenant\Report\Controllers'], function () {
        get('report', 'ReportController@index');
    });

    Route::group(['namespace' => 'Tenant\Inventory\Controllers'], function () {
        // product routes
        get('inventory/product', ['as' => 'tenant.inventory.product.index', 'uses' => 'ProductController@index']);
        post('inventory/product', ['as' => 'tenant.inventory.product.post', 'uses' => 'ProductController@create']);
        get('inventory/product/{id}/detail', ['as' => 'tenant.inventory.product.show', 'uses' => 'ProductController@detail']);
        post('inventory/product/data', ['as' => 'tenant.inventory.product.data', 'uses' => 'ProductController@dataJson']);
        get('inventory/product/{id}/edit', ['as' => 'tenant.inventory.product.edit', 'uses' => 'ProductController@edit']);
        post('inventory/product/{id}/edit', ['as' => 'tenant.inventory.product.update', 'uses' => 'ProductController@update']);
        get('inventory/product/{id}/delete', ['as' => 'tenant.inventory.product.delete', 'uses' => 'ProductController@delete']);
        get('inventory/stock', ['as' => 'tenant.inventory.stock', 'uses' => 'ProductController@stock']);


        // Registered By Krita
        get('product/suggestions', ['as' => 'tenant.product.suggestions', 'uses' => 'ProductController@getSuggestions']);

        // inventory routes
        get('inventory', ['as' => 'tenant.inventory.index', 'uses' => 'InventoryController@index']);
        post('inventory', ['as' => 'tenant.inventory.post', 'uses' => 'InventoryController@create']);
        post('inventory/data', ['as' => 'tenant.inventory.data', 'uses' => 'InventoryController@dataJson']);
        get('inventory/{id}', ['as' => 'tenant.inventory.show', 'uses' => 'InventoryController@show']);
        post('inventory/{id}/edit', ['as' => 'tenant.inventory.update', 'uses' => 'InventoryController@update']);
        get('inventory/{id}/edit', ['as' => 'tenant.inventory.edit', 'uses' => 'InventoryController@edit']);
        get('inventory/{id}/delete', ['as' => 'tenant.inventory.delete', 'uses' => 'InventoryController@delete']);

        // Registered By Pooja
        //get('inventory/stock', ['as' => 'tenant.inventory.stock', 'uses' => 'InventoryController@index']);
    });

    /** Registered by Krita **/
    Route::group(['namespace' => 'Tenant\Invoice\Controllers'], function () {

        // bill routes
        get('invoice/bill', ['as' => 'tenant.invoice.bill.index', 'uses' => 'BillController@index']);
        get('invoice/bill/add', ['as' => 'tenant.invoice.bill.add', 'uses' => 'BillController@add']);
        post('invoice/bill/add', ['as' => 'tenant.invoice.bill.post', 'uses' => 'BillController@create']);
        post('invoice/bill/data', ['as' => 'tenant.invoice.bill.data', 'uses' => 'BillController@dataJson']);
        get('invoice/bill/{id}', ['as' => 'tenant.invoice.bill.view', 'uses' => 'BillController@view']);
        get('invoice/bill/{id}/edit', ['as' => 'tenant.invoice.bill.edit', 'uses' => 'BillController@edit']);
        post('invoice/bill/{id}/edit', ['as' => 'tenant.invoice.bill.update', 'uses' => 'BillController@update']);
        get('invoice/bill/{id}/delete', ['as' => 'tenant.invoice.bill.delete', 'uses' => 'BillController@delete']);
        get('invoice/bill/{id}/download', ['as' => 'tenant.invoice.bill.download', 'uses' => 'BillController@download']);
        get('invoice/bill/{id}/print', ['as' => 'tenant.invoice.bill.download', 'uses' => 'BillController@printBill']);
        get('invoice/bill/{id}/mail', ['as' => 'tenant.invoice.bill.email', 'uses' => 'BillController@sendEmail']);
        post('invoice/bill/{id}/payment', ['as' => 'tenant.invoice.bill.payment', 'uses' => 'BillController@payment']);
        get('invoice/bill/{id}/credit', ['as' => 'tenant.invoice.bill.credit', 'uses' => 'BillController@credit']);

        // invoice routes
        get('invoice', ['as' => 'tenant.invoice.index', 'uses' => 'InvoiceController@index']);

        // offer routes
        get('invoice/offer', ['as' => 'tenant.invoice.offer.index', 'uses' => 'OfferController@index']);
        get('invoice/offer/add', ['as' => 'tenant.invoice.offer.add', 'uses' => 'OfferController@add']);
        post('invoice/offer/add', ['as' => 'tenant.invoice.offer.post', 'uses' => 'OfferController@create']);
        post('invoice/offer/data', ['as' => 'tenant.invoice.offer.data', 'uses' => 'OfferController@dataJson']);
        get('invoice/offer/{id}', ['as' => 'tenant.invoice.offer.show', 'uses' => 'OfferController@show']);
        get('invoice/offer/{id}/edit', ['as' => 'tenant.invoice.offer.edit', 'uses' => 'OfferController@edit']);
        post('invoice/offer/{id}/edit', ['as' => 'tenant.invoice.offer.update', 'uses' => 'OfferController@update']);
        get('invoice/offer/{id}/delete', ['as' => 'tenant.invoice.offer.delete', 'uses' => 'OfferController@delete']);
        get('invoice/offer/{id}/download', ['as' => 'tenant.invoice.offer.download', 'uses' => 'BillController@download']);
        get('invoice/offer/{id}/print', ['as' => 'tenant.invoice.offer.print', 'uses' => 'BillController@printBill']);
        get('invoice/offer/{id}/convert', ['as' => 'tenant.invoice.offer.convert', 'uses' => 'OfferController@convertToBill']);
    });

    /** Registered by Krita **/
    Route::group(['namespace' => 'Tenant\Supplier\Controllers'], function () {
        get('supplier', ['as' => 'tenant.supplier.index', 'uses' => 'SupplierController@index']);
        post('supplier', ['as' => 'tenant.supplier.create', 'uses' => 'SupplierController@create']);
        get('supplier/{id}/delete', ['as' => 'supplier.delete', 'uses' => 'SupplierController@deleteSupplier']);
        get('supplier/{id}/edit', ['as' => 'tenant.supplier.edit', 'uses' => 'SupplierController@edit']);
        post('supplier/{id}/edit', ['as' => 'tenant.supplier.edit', 'uses' => 'SupplierController@update']);
        post('supplier/data', ['as' => 'tenant.supplier.data', 'uses' => 'SupplierController@dataJson']);
        post('supplier/upload', ['as' => 'tenant.supplier.upload', 'uses' => 'SupplierController@upload']);
        post('supplier/changeStatus', ['as' => 'tenant.supplier.changeStatus', 'uses' => 'SupplierController@changeStatus']);
        get('supplier/suggestions', ['as' => 'tenant.supplier.suggestions', 'uses' => 'SupplierController@getSupplierSuggestions']);
    });

    Route::group(['namespace' => 'Tenant\Tasks\Controllers'], function () {
        // bill routes
        get('tasks', ['as' => 'tenant.tasks.index', 'uses' => 'TasksController@index']);
        post('tasks', ['as' => 'tenant.tasks.post', 'uses' => 'TasksController@create']);
        post('tasks/data', ['as' => 'tenant.tasks.data', 'uses' => 'TasksController@dataJson']);
        get('tasks/{id}', ['as' => 'tenant.tasks.show', 'uses' => 'TasksController@show']);
        get('tasks/{id}/edit', ['as' => 'tenant.tasks.edit', 'uses' => 'TasksController@edit']);
        post('tasks/{id}/edit', ['as' => 'tenant.tasks.update', 'uses' => 'TasksController@update']);
        get('tasks/{id}/delete', ['as' => 'tenant.tasks.delete', 'uses' => 'TasksController@delete']);
        get('tasks/{id}/complete', ['as' => 'tenant.tasks.complete', 'uses' => 'TasksController@complete']);
        get('tasks/{id}/redo', ['as' => 'tenant.tasks.redo', 'uses' => 'TasksController@complete']);
    });

    Route::group(['namespace' => 'Tenant\Accounting\Controllers'], function () {
        get('accounting', ['as' => 'tenant.accounting.index', 'uses' => 'ListController@index']);
        get('accounting/{id}/pay', ['as' => 'tenant.accounting.pay', 'uses' => 'ListController@pay']);
        post('accounting/{id}/pay', ['as' => 'tenant.accounting.register.payment', 'uses' => 'ListController@registerPayment']);
        post('accounting/data', ['as' => 'tenant.accounting.data', 'uses' => 'ListController@dataJson']);
        get('delete/expense/{id}', ['as' => 'tenant.expense.delete', 'uses' => 'ListController@deleteExpense']);

        // for expense
        get('accounting/expense', ['as' => 'tenant.accounting.expense', 'uses' => 'ExpenseController@index']);
        get('accounting/expense/{id}', ['as' => 'tenant.accounting.expense.details', 'uses' => 'ExpenseController@details']);
        post('accounting/expense', ['as' => 'tenant.accounting.create.expense', 'uses' => 'ExpenseController@createExpense']);
        get('expense/{id}/edit', ['as' => 'tenant.expense.edit', 'uses' => 'ExpenseController@edit']);
        post('expense/{id}/edit', ['as' => 'tenant.expense.update', 'uses' => 'ExpenseController@update']);

        post('accounting', ['as' => 'tenant.accounting.create', 'uses' => 'AccountingController@create']);
        get('accounting/payroll', ['as' => 'tenant.accounting.payroll', 'uses' => 'AccountingController@payroll']);
        get('accounting/payroll/add', ['as' => 'tenant.accounting.payroll.add', 'uses' => 'AccountingController@addPayroll']);
        post('accounting/payroll/add', ['as' => 'tenant.accounting.payroll.create', 'uses' => 'AccountingController@createPayroll']);
        get('payout/details/{employeeId}', ['as' => 'tenant.accounting.payroll.create', 'uses' => 'AccountingController@employeePayrollDetails']);
        get('accounting/open', 'AccountingController@open');
        get('accounting/close', 'AccountingController@close');

        get('accounting/vat', 'AccountingController@vat');
        post('accounting/vat/entries', 'AccountingController@entries');
        post('accounting/vat/action/{action}', 'AccountingController@action');

        get('accounting/setup', 'AccountingController@setup');
        get('accounting/new-business', 'AccountingController@newBusiness');
        get('accounting/transactions',  ['as' => 'tenant.accounting.transaction', 'uses' =>'TransactionController@index']);
    });

    Route::group(['namespace' => 'Tenant\Collection\Controllers'], function () {
        get('collection', ['as' => 'tenant.collection.index', 'uses' => 'CollectionController@index']);
        get('collection/waiting', ['as' => 'tenant.collection.waiting', 'uses' => 'CollectionController@waiting']);
        get('collection/case/create', ['as' => 'tenant.collection.case.create', 'uses' => 'CollectionController@addCase']);
        post('collection/case/create', ['as' => 'tenant.collection.case.create', 'uses' => 'CollectionController@createCase']);
        post('collection/data', ['as' => 'tenant.collection.data', 'uses' => 'CollectionController@data']);
        post('collection/waiting/data', ['as' => 'tenant.collection.waiting.data', 'uses' => 'CollectionController@waitingData']);
        get('collection/case/{id}/create', ['as' => 'tenant.collection.case.make', 'uses' => 'CollectionController@makeCollectionCase']);
        post('collection/court-case/create', [ 'uses' => 'CollectionController@createCourtCase']);
        get('collection/case/register-date', [ 'uses' => 'CollectionController@registerDate']);
        get('collection/case/history', [ 'uses' => 'CollectionController@caseHistory']);
        post('collection/case/{bill}/payment-date', [ 'uses' => 'CollectionController@casePaymentDate']);

        get('collection/{step}/pdf', ['as' => 'tenant.collection.pdf', 'uses' => 'CollectionController@generatePdf']);
        get('collection/gotostep/{step}', ['as' => 'tenant.collection.goto', 'uses' => 'CollectionController@goToStep']);
        get('collection/dispute', ['as' => 'tenant.collection.dispute', 'uses' => 'CollectionController@disputeBill']);
        get('collection/cancel', ['as' => 'tenant.collection.cancel', 'uses' => 'CollectionController@cancel']);

        get('collection/purring', ['as' => 'tenant.collection.purring', 'uses' => 'CollectionController@purring']);
        get('collection/payment', ['as' => 'tenant.collection.payment', 'uses' => 'CollectionController@payment']);
        get('collection/debt', ['as' => 'tenant.collection.debt', 'uses' => 'CollectionController@debt']);
        get('collection/options', ['as' => 'tenant.collection.options', 'uses' => 'CollectionController@options']);
        get('collection/case', ['as' => 'tenant.collection.case', 'uses' => 'CollectionController@courtCase']);
        get('collection/case/followUp', ['as' => 'tenant.collection.case.followup', 'uses' => 'CollectionController@followup']);
        get('collection/utlegg', ['as' => 'tenant.collection.utlegg', 'uses' => 'CollectionController@utlegg']);
        get('collection/utlegg/followup', ['as' => 'tenant.collection.utlegg.followup', 'uses' => 'CollectionController@utleggFollowup']);
    });

    /*
     * Todo : don't register new routes under this group
     * Todo we need to change below routes to modular
     */
    Route::group(['namespace' => 'Controllers'], function () {

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
        get('edit/profile', ['as' => 'tenant.edit.profile', 'uses' => 'Tenant\Settings\UserController@index']);
        post('edit/profile', ['as' => 'tenant.edit.profile', 'uses' => 'Tenant\Settings\UserController@update']);
        get('setting/template', ['as' => 'tenant.setting.template', 'uses' => 'Tenant\SettingController@template']);
        post('setting/update', ['as' => 'tenant.setting.update', 'uses' => 'Tenant\SettingController@update']);
        get('profile', ['as' => 'tenant.profile', 'uses' => 'Tenant\DashboardController@profile']);
        get('change-password', ['as' => 'tenant.auth.changePassword', 'uses' => 'Tenant\AuthController@changePassword']);
        post('change-password', ['as' => 'tenant.auth.postUserPasswordChange', 'uses' => 'Tenant\AuthController@postUserPasswordChange']);

        //registered by : Krita
        get('city/suggestions/{postalCode}', ['as' => 'tenant.zip.town', 'uses' => 'Tenant\SetupController@getZipTown']);
        get('postal/suggestions', ['as' => 'tenant.zip.postal', 'uses' => 'Tenant\SetupController@getPostalCode']);
        get('users', ['as' => 'tenant.users', 'uses' => 'Tenant\Users\UserController@index']);
        post('users', ['as' => 'tenant.user.save', 'uses' => 'Tenant\Users\UserController@saveUser']);
        get('customer', ['as' => 'tenant.customer', 'uses' => 'Tenant\CustomerController@index']);
        get('block/user/{guid}', ['as' => 'subuser.block', 'uses' => 'Tenant\Users\UserController@blockUser']);
        get('unblock/user/{guid}', ['as' => 'subuser.unblock', 'uses' => 'Tenant\Users\UserController@unblockUser']);
        get('delete/user/{guid}', ['as' => 'subuser.delete', 'uses' => 'Tenant\Users\UserController@deleteUser']);
        get('update/user/{guid}', ['as' => 'subuser.update', 'uses' => 'Tenant\Users\UserController@getUpdate']);
        post('user/update', ['as' => 'tenant.user.update', 'uses' => 'Tenant\Users\UserController@updateUser']);
        get('user/{guid}', ['as' => 'subuser.profile', 'uses' => 'Tenant\Users\UserController@profile']);
        post('user/data', ['as' => 'tenant.user.data', 'uses' => 'Tenant\Users\UserController@dataJson']);
        get('user/registerDays/{type}/{guid}', ['as' => 'user.registerDays', 'uses' => 'Tenant\Users\UserController@registerVacation']);
        post('user/addVacation', ['as' => 'user.addVacation', 'uses' => 'Tenant\Users\UserController@addVacation']);
        post('user/deleteVacation', ['as' => 'user.deleteVacation', 'uses' => 'Tenant\Users\UserController@deleteVacation']);
        get('employee/suggestions', ['as' => 'tenant.employee.suggestions', 'uses' => 'Tenant\Users\UserController@getEmployeeSuggestions']);

        //registered by : Pooja

        get('customer', ['as' => 'tenant.customer.index', 'uses' => 'Tenant\Customer\CustomerController@index']);
        post('customer', ['as' => 'tenant.customer.create', 'uses' => 'Tenant\Customer\CustomerController@create']);
        get('customer/CustomerCard/{id}', ['as' => 'tenant.customer.CustomerCard', 'uses' => 'Tenant\Customer\CustomerController@customerCard']);
        get('customer/{id}/delete', ['as' => 'customer.delete', 'uses' => 'Tenant\Customer\CustomerController@deleteCustomer']);
        get('customer/{id}/edit', ['as' => 'tenant.customer.edit', 'uses' => 'Tenant\Customer\CustomerController@edit']);
        post('customer/{id}/edit', ['as' => 'tenant.customer.edit', 'uses' => 'Tenant\Customer\CustomerController@update']);
        post('customer/data', ['as' => 'tenant.customer.data', 'uses' => 'Tenant\Customer\CustomerController@dataJson']);
        post('customer/upload', ['as' => 'tenant.customer.upload', 'uses' => 'Tenant\Customer\CustomerController@upload']);
        post('customer/changeStatus', ['as' => 'tenant.customer.changeStatus', 'uses' => 'Tenant\Customer\CustomerController@changeStatus']);

        //registered by Krita
        get('customer/suggestions', ['as' => 'tenant.customer.suggestions', 'uses' => 'Tenant\Customer\CustomerController@getCustomerSuggestions']);
        get('customer/details/{customerId}', ['as' => 'tenant.customer.details', 'uses' => 'Tenant\Customer\CustomerController@getCustomerDetails']);
        post('test/upload', ['as' => 'test.upload', 'uses' => 'Tenant\Customer\CustomerController@testUpload']);
        post('customer/invoices/data', ['as' => 'tenant.inventory.customer.data', 'uses' => 'Tenant\Customer\CustomerController@invoices']);

    });


});
