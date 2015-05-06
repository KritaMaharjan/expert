<?php
/**
 * User: manishg.singh
 * Date: 2/23/2015
 * Time: 11:56 AM
 */

namespace App\Fastbooks\Libraries;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class TenantTable {

    /**
     * Constant for table prefix
     */
    protected $tbl_profix = 'fb_';

    function __construct()
    {
        $this->tbl_profix = env('ROOT_TABLE_PREFIX', 'fb_');
    }

    /**
     * Run all table SQL
     */
    public function run()
    {
        $this->users();
        $this->settings();
        $this->passwordReset();
        $this->profile();
        $this->customers();
        $this->emails();
        $this->emailReceivers();
        $this->attachmentsEmail();
        $this->incomingEmails();
        $this->products();
        $this->inventory();
        $this->bill();
        $this->billProducts();
        $this->billPayment();
        $this->tasks();
        $this->vacation();
        $this->payroll();
        $this->suppliers();
        $this->expenses();
        $this->expenseProducts();
        $this->expensePayment();
        $this->accountCodes();
        $this->transactions();
        $this->entries();
        $this->vatPeriod();
    }

    /**
     * Users Tables [used for Tenant admin and sub-user ]
     */
    private function users()
    {
        if (!Schema::hasTable($this->tbl_profix . 'users')) {
            Schema::create($this->tbl_profix . 'users', function ($table) {
                $table->increments('id'); // autoincrement value of a tenant admin
                $table->string('guid', 45)->unique(); // unique random ID for a user
                $table->string('fullname', 45); // fullname of a user
                $table->string('email', 100)->unique(); // email ID of a user
                $table->string('password', 70); // password of a user
                $table->tinyInteger('role')->unsigned()->default(0); // role of a user by default invalid
                $table->tinyInteger('status')->unsigned()->default(0); // status of a user by default pending activation
                $table->string('activation_key', 50); //activation key for confirmation
                $table->text('permissions')->nullable(); // serialized data of permissions
                $table->datetime('last_login')->nullable(); // last login Date time
                $table->datetime('last_login_ip', 20)->nullable(); // last login IP
                $table->string('suspended_reason')->nullable(); // suspended reason set by admin
                $table->boolean('first_time')->default(1); // 1 for first time login

                // remembers token column
                $table->rememberToken();

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Tenant admin settings table
     */
    private function settings()
    {
        if (!Schema::hasTable($this->tbl_profix . 'settings')) {
            Schema::create($this->tbl_profix . 'settings', function ($table) {
                $table->increments('id'); // autoincrement value of a setting
                $table->string('name', 30)->unique(); // unique key for setting
                $table->text('value')->nullable(); // value of a setting

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Password Reset Table
     */
    private function passwordReset()
    {
        if (!Schema::hasTable($this->tbl_profix . 'password_resets')) {
            Schema::create($this->tbl_profix . 'password_resets', function (Blueprint $table) {
                $table->string('email')->index();  // user's email ID
                $table->string('token')->index(); // token for verification
                // created_at DATETIME
                $table->timestamp('created_at');
            });
        }
    }

    /**
     * User profile table [one to one relation with users table]
     */
    private function profile()
    {
        if (!Schema::hasTable($this->tbl_profix . 'profile')) {
            Schema::create($this->tbl_profix . 'profile', function (Blueprint $table) {
                // $table->increments('id'); // autoincrement value of a profile
                $table->integer('user_id')->unsign()->unique(); // user id from user table
                $table->text('smtp')->nullable(); // serialized value of personal email setting
                $table->integer('social_security_number')->nullable(); // social security number of a user
                $table->bigInteger('phone')->nullable(); // phone number of a user
                $table->string('address', 100)->nullable(); // address of a user
                $table->string('photo', 50)->nullable(); // profile image of a user
                $table->string('postcode', 10)->nullable(); // postcode of a user
                $table->string('town', 45)->nullable(); // town of a user
                $table->string('tax_card', 15)->nullable(); // tax card of a user
                $table->float('vacation_fund_percentage')->nullable(); // vacation fund percentage of a user
                $table->text('comment')->nullable(); // comment by admin

                // updated_at DATETIME
                $table->timestamps('updated_at');

            });
        }
    }

    /**
     * Customers tables [Many to one relation with users]
     */
    private function customers()
    {
        if (!Schema::hasTable($this->tbl_profix . 'customers')) {
            Schema::create($this->tbl_profix . 'customers', function ($table) {
                $table->increments('id'); // autoincrement value of a customer
                $table->string('guid', 32); // unique auto generated ID of a customer
                $table->integer('user_id')->unsign()->index(); //user id, who created the customer
                $table->string('email', 100)->unique(); // email ID of a user
                $table->integer('type')->unsign()->index(); //'1 - human - company' ,
                $table->string('name', 45); //'name of a customer (human or company)'
                $table->string('company_number', 30)->nullable(); //'company registration no of a company'
                $table->date('dob')->nullable(); //'dob of human'
                $table->string('street_name', 70); //'street address of a customer'
                $table->string('street_number', 15); //'street number of a customer'
                $table->string('postcode', 10); //'postcode of a customer'
                $table->string('town', 55); //'town of a customer'
                $table->bigInteger('telephone')->nullable();//'telephone number of a customer'
                $table->bigInteger('mobile')->nullable();//'mobile number of a customer'
                $table->string('image', 50)->nullable(); //'image or logo of a customer'
                $table->string('file', 50)->nullable(); //'file of a customer'
                $table->tinyInteger('status'); //'1 - active\n0 - inactive'

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }


    /*
     * Table for Sent emails
     * */
    private function emails()
    {
        if (!Schema::hasTable($this->tbl_profix . 'emails')) {
            Schema::create($this->tbl_profix . 'emails', function (Blueprint $table) {
                $table->increments('id'); // autoincrement value of an email
                $table->integer('sender_id')->unsign()->index(); //sender user id
                $table->text('message'); //message for email
                $table->string('subject'); //subject for email
                $table->text('note'); //note for email
                $table->tinyInteger('status'); // email action status
                $table->tinyInteger('type')->default('0'); //'0 for personal, 1 for support'

                // created_at DATETIME
                $table->timestamps();
            });
        }

    }

    /*
     * Email Receivers [ one to many relation with Emails table]
     * */

    private function emailReceivers()
    {
        if (!Schema::hasTable($this->tbl_profix . 'email_receivers')) {
            Schema::create($this->tbl_profix . 'email_receivers', function (Blueprint $table) {
                $table->increments('id'); // autoincrement value of an receiver
                $table->integer('email_id')->unsign()->index(); //email ID
                $table->integer('customer_id')->unsign()->index()->nullable(); //customer ID
                $table->string('email', 100); //email Address
                $table->tinyInteger('type')->default(1); //'1 for to, 2 for cc, 3 for bcc'
            });
        }
    }

    /*
    * Email Attachments [One to many relation with Emails table]
     * */

    private function attachmentsEmail()
    {
        if (!Schema::hasTable($this->tbl_profix . 'attachments_email')) {
            Schema::create($this->tbl_profix . 'attachments_email', function (Blueprint $table) {
                $table->increments('id'); // autoincrement value of an attachment
                $table->integer('email_id')->unsign()->index(); //email id
                $table->string('file', 75); //file name
            });
        }
    }

    /*
    * Incoming Emails
    *
    */
    private function incomingEmails()
    {
        if (!Schema::hasTable($this->tbl_profix . 'incoming_emails')) {
            Schema::create($this->tbl_profix . 'incoming_emails', function (Blueprint $table) {
                $table->increments('id'); // autoincrement value of an attachment
                $table->integer('user_id')->unsign()->index()->nullable(); //User id
                $table->integer('msid')->unsign()->index(); //Mail unique id
                $table->string('from_email', 100); //From email Address
                $table->string('from_name', 100); //From Name
                $table->string('subject', 255); //Subject of an email
                $table->text('body_html'); //mail body in html format
                $table->text('body_text'); //mail body in plain text
                $table->text('attachments')->nullable(); //store all attachments as serialised value
                $table->tinyInteger('type')->default(1); //'0 for personal, 1 for support'
                $table->tinyInteger('is_seen')->default(0); //'0 for unseen, 1 for seen'
                $table->dateTime('received_at');
                // created_at DATETIME
                $table->timestamps('created_at');
            });
        }
    }


    /**
     * Items table for inventory [Many to one relation with inventory table]
     */
    private function products()
    {
        if (!Schema::hasTable($this->tbl_profix . 'products')) {
            Schema::create($this->tbl_profix . 'products', function (Blueprint $table) {
                $table->increments('id'); // autoincrement value of a product
                $table->integer('user_id')->unsign()->index(); //user id who added the product
                $table->string('number', 25)->unique();  // product
                $table->string('name', 100)->unique();  // name of an product
                $table->float('vat'); // Vat percentage applied for the product
                $table->decimal('selling_price', 11, 2); //price of an product
                $table->decimal('purchase_cost', 11, 2); //price of an product

                // created_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Inventory Table (used to record all the inventory items)
     */
    private function inventory()
    {
        if (!Schema::hasTable($this->tbl_profix . 'inventory')) {
            Schema::create($this->tbl_profix . 'inventory', function (Blueprint $table) {
                $table->increments('id'); // autoincrement value of an product
                $table->integer('product_id')->index(); //product id
                $table->integer('user_id')->index();  // name of an product
                $table->integer('quantity'); // quantity of an product
                $table->float('vat'); // Vat percentage applied for the product
                $table->decimal('selling_price', 11, 2); //price of an product
                $table->decimal('purchase_cost', 11, 2); //price of an product
                $table->date('purchase_date'); // Add time or purchased date of an product

                // created_at DATETIME
                $table->timestamps();
            });
        }
    }


    /**
     * Table for Bills [Many to one relation with customer table]
     */
    private function bill()
    {
        if (!Schema::hasTable($this->tbl_profix . 'bill')) {
            Schema::create($this->tbl_profix . 'bill', function ($table) {
                $table->increments('id'); // autoincrement value of a tenant admin
                $table->string('invoice_number', 25);
                $table->integer('customer_id')->index(); // customer id
                $table->string('currency', 10);
                $table->float('subtotal');
                $table->float('vat');
                $table->float('vat_amount');
                $table->float('shipping')->default(0);
                $table->float('total');
                $table->float('paid')->default(0);
                $table->float('remaining');
                $table->boolean('status')->default(0); // 0: unpaid, 1: paid, 2: partially paid
                $table->boolean('payment')->default(0); // 0: active, 1: collection, 2: loss, 3: credit
                $table->string('customer_payment_number', 60)->nullable();
                $table->boolean('is_offer')->default(0); // 0: no (bill), 1: yes (offer)
                $table->date('due_date');
                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Table for Product [Many to one relation with bills table]
     */
    private function billProducts()
    {
        if (!Schema::hasTable($this->tbl_profix . 'bill_products')) {
            Schema::create($this->tbl_profix . 'bill_products', function ($table) {
                $table->increments('id'); // autoincrement value
                $table->integer('product_id')->index(); // product id
                $table->integer('bill_id')->index(); // bill id
                $table->integer('quantity');
                $table->decimal('price', 11, 2);
                $table->float('vat');
                $table->string('currency', 10);
                $table->float('total');

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Bill Payment
     */
    private function billPayment()
    {
        if (!Schema::hasTable($this->tbl_profix . 'bill_payment')) {
            Schema::create($this->tbl_profix . 'bill_payment', function ($table) {
                $table->increments('id'); // autoincrement value
                $table->integer('bill_id'); //Bill id
                $table->decimal('amount_paid', 11, 2); // payment amount
                $table->date('payment_date'); // payment due date

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Table for Tasks in to do list
     */
    private function tasks()
    {
        if (!Schema::hasTable($this->tbl_profix . 'tasks')) {
            Schema::create($this->tbl_profix . 'tasks', function ($table) {
                $table->increments('id'); // autoincrement value of a tenant admin
                $table->integer('user_id'); // autoincrement value of a tenant admin
                $table->string('subject', 100);
                $table->text('body'); // customer id
                $table->datetime('due_date');
                $table->boolean('is_complete')->default(0); // 0: not complete, 1: complete
                $table->datetime('completion_date');
                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Vacation and sick leave table
     * @todo we need to change table name to leave
     */
    private function vacation()
    {
        if (!Schema::hasTable($this->tbl_profix . 'vacation')) {
            Schema::create($this->tbl_profix . 'vacation', function ($table) {
                $table->increments('id'); // autoincrement value of a vacation
                $table->integer('user_id')->unsign()->index();
                $table->integer('vacation_days')->unsign()->index();
                $table->integer('sick_days')->unsign()->index();
                $table->date('from');
                $table->date('to');

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /* ---------------------------------------
     * Tables for Accounting Module
     * ---------------------------------------
     */
    private function payroll()
    {
        if (!Schema::hasTable($this->tbl_profix . 'payroll')) {
            Schema::create($this->tbl_profix . 'payroll', function ($table) {
                $table->increments('id'); // autoincrement value
                $table->integer('user_id')->unsign()->index(); // employee ID
                $table->tinyInteger('type')->default(1); //Salary type 0:hourly, 1:monthly
                $table->float('worked'); // worked hours/month of an employee
                $table->decimal('rate', 11, 2); // rate (hourly | monthly) of employee
                $table->decimal('basic_salary', 11, 2); // Basic salary

                $table->decimal('other_payment', 11, 2); // other payment made for employee
                $table->text('description'); // some description about payroll

                $table->decimal('total_salary', 11, 2); // total salary of an employment

                $table->float('tax_rate'); // tax in percentage
                $table->float('vacation_fund'); // vacation fund in percentage
                $table->float('payroll_tax'); // payroll tax in percentage

                $table->decimal('total_paid', 11, 2); // total paid to employment
                $table->date('payment_date'); // Date of payment

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Suppliers table
     */
    private function suppliers()
    {
        if (!Schema::hasTable($this->tbl_profix . 'suppliers')) {
            Schema::create($this->tbl_profix . 'suppliers', function ($table) {
                $table->increments('id'); // autoincrement value of a suppliers
                $table->string('guid', 32); // unique auto generated ID of a suppliers
                $table->integer('user_id')->unsign()->index(); //user id, who created the suppliers
                $table->string('email', 100)->unique(); // email ID of a user
                $table->integer('type')->unsign()->index(); //'1 - human - company' ,
                $table->string('name', 45); //'name of a suppliers (human or company)'
                $table->string('company_number', 30)->nullable(); //'company registration no of a company'
                $table->date('dob')->nullable(); //'dob of human'
                $table->string('street_name', 70); //'street address of a suppliers'
                $table->string('street_number', 15); //'street number of a suppliers'
                $table->string('postcode', 10); //'postcode of a suppliers'
                $table->string('town', 55); //'town of a suppliers'
                $table->bigInteger('telephone')->nullable();//'telephone number of a suppliers'
                $table->bigInteger('mobile')->nullable();//'mobile number of a suppliers'
                $table->string('image', 50)->nullable(); //'image or logo of a suppliers'
                $table->string('file', 50)->nullable(); //'file of a suppliers'
                $table->tinyInteger('status'); //'1 - active\n0 - inactive'

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Account Expense Table
     */
    private function expenses()
    {
        if (!Schema::hasTable($this->tbl_profix . 'expenses')) {
            Schema::create($this->tbl_profix . 'expenses', function ($table) {
                $table->increments('id'); // autoincrement value
                $table->tinyInteger('type'); // 1:supplier, 2:cash
                $table->integer('supplier_id')->nullable(); //supplier id if purchase in credit
                $table->date('billing_date'); //Billing date
                $table->date('payment_due_date'); // payment due date
                $table->integer('invoice_number'); // invoice number
                $table->string('bill_image', 70)->nullable(); // bill image
                $table->decimal('amount', 11, 2)->default(0);
                $table->decimal('subtotal', 11, 2)->default(0);
                $table->float('vat');
                $table->decimal('paid', 11, 2)->default(0);
                $table->decimal('remaining', 11, 2)->default(0);
                $table->tinyInteger('is_paid')->default(0); // 0:unpaid 1 for paid

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }


    /**
     * Expense product table
     */
    private function expenseProducts()
    {
        if (!Schema::hasTable($this->tbl_profix . 'expense_products')) {
            Schema::create($this->tbl_profix . 'expense_products', function ($table) {
                $table->increments('id'); // autoincrement value of a vacation
                $table->integer('expense_id'); //Expense id
                $table->text('text'); //Billing date
                $table->decimal('amount', 11, 2); // amount without tax
                $table->decimal('total', 11, 2); // total payment amount
                $table->float('vat'); // payment due date
                $table->integer('account_code_id'); //account id from account code table

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }

    }


    /**
     * Expense Payment table
     */
    private function expensePayment()
    {
        if (!Schema::hasTable($this->tbl_profix . 'expense_payment')) {
            Schema::create($this->tbl_profix . 'expense_payment', function ($table) {
                $table->increments('id'); // autoincrement value
                $table->integer('user_id'); // user id for the entry person
                $table->integer('expense_id'); //Expense id
                $table->decimal('amount_paid', 11, 2); // payment amount
                $table->tinyInteger('payment_method'); // 1:cash , 2:bank
                $table->date('payment_date'); // payment due date

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Account codes
     */
    private function accountCodes()
    {
        if (!Schema::hasTable($this->tbl_profix . 'account_codes')) {
            Schema::create($this->tbl_profix . 'account_codes', function ($table) {
                $table->increments('id'); // autoincrement value of a vacation
                $table->integer('code');
                $table->string('account_en');
                $table->string('account_no');
                $table->string('subledger');
                $table->string('nature');
                $table->string('note')->nullable();
            });
        }
    }

    /**
     * All account related transaction stored in this table
     */
    private function transactions()
    {
        if (!Schema::hasTable($this->tbl_profix . 'transactions')) {
            Schema::create($this->tbl_profix . 'transactions', function ($table) {
                $table->increments('id'); // autoincrement value
                $table->integer('user_id'); // user id for entry user
                $table->integer('accounting_year_id');
                $table->string('description', 255); //account id from account code table
                $table->decimal('amount', 11, 2); // Transaction amount
                $table->float('vat')->nullable(); // Transaction vat
                $table->tinyInteger('type'); // 1: Bill , 2: Expenses
                $table->integer('type_id'); // Transaction amount
                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }


    /**
     * Entries table : one to many relation with transactions
     */
    private function entries()
    {
        if (!Schema::hasTable($this->tbl_profix . 'entries')) {
            Schema::create($this->tbl_profix . 'entries', function ($table) {
                $table->increments('id'); // autoincrement value of a vacation
                $table->integer('transaction_id'); //transaction id from account code table
                $table->integer('account_code'); //account code from config
                $table->integer('subledger'); // sub-ledger
                $table->decimal('amount', 11, 2); // Transaction amount
                $table->text('description'); // transaction description
                $table->tinyInteger('type'); // 1: Debit , 2: credit
            });
        }
    }

    /**
     * Vat Period table
     */
    private function vatPeriod()
    {
        if (!Schema::hasTable($this->tbl_profix . 'vat_period')) {
            Schema::create($this->tbl_profix . 'entries', function ($table) {
                $table->increments('id'); // autoincrement value
                $table->integer('period'); // period
                $table->integer('year'); // account year
                $table->tinyInteger('status'); // 0 : active, 1 : sent, 2 :paid
                $table->date('sent_date'); // Sent date
                $table->date('paid_date'); // Paid date
                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }
}