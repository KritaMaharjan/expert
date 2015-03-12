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
    const TBL_PREFIX = 'fb_';

    /**
     * Users Tables [used for Tenant admin and sub-user ]
     */
    function users()
    {
        if (!Schema::hasTable(self::TBL_PREFIX . 'users')) {
            Schema::create(self::TBL_PREFIX . 'users', function ($table) {
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
                $table->string('suspended_reason'); // suspended reason set by admin
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
    function settings()
    {
        if (!Schema::hasTable(self::TBL_PREFIX . 'settings')) {
            Schema::create(self::TBL_PREFIX . 'settings', function ($table) {
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
    function passwordReset()
    {
        if (!Schema::hasTable(self::TBL_PREFIX . 'password_resets')) {
            Schema::create(self::TBL_PREFIX . 'password_resets', function (Blueprint $table) {
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
    function profile()
    {
        if (!Schema::hasTable(self::TBL_PREFIX . 'profile')) {
            Schema::create(self::TBL_PREFIX . 'profile', function (Blueprint $table) {
                // $table->increments('id'); // autoincrement value of a profile
                $table->integer('user_id')->unsign()->index(); // user id from user table
                $table->text('personal_email_setting'); // serialized value of personal email setting
                $table->text('support_email_setting'); // serialized value of support email setting
                $table->integer('social_security_number')->nullable(); // social security number of a user
                $table->bigInteger('phone'); // phone number of a user
                $table->string('address', 100); // address of a user
                $table->string('photo', 50)->nullable(); // profile image of a user
                $table->string('postcode', 10); // postcode of a user
                $table->string('town', 45); // town of a user
                $table->string('tax_card', 15); // tax card of a user
                $table->float('vacation_fund_percentage'); // vacation fund percentage of a user
                $table->text('comment'); // comment by admin

                // updated_at DATETIME
                $table->timestamps('updated_at');

            });
        }
    }

    /**
     * Customers tables [Many to one relation with users]
     */
    function customers()
    {
        if (!Schema::hasTable(self::TBL_PREFIX . 'customers')) {
            Schema::create(self::TBL_PREFIX . 'customers', function ($table) {
                $table->increments('id'); // autoincrement value of a customer
                $table->string('guid', 32); // unique auto generated ID of a customer
                $table->integer('user_id')->unsign()->index(); //user id, who created the customer
                $table->string('email', 100)->unique(); // email ID of a user
                $table->integer('type')->unsign()->index(); //'1 - human - company' ,
                $table->string('name', 45); //'name of a customer (human or company)'
                $table->date('dob'); //'dob of human'
                $table->string('street_name', 70); //'street address of a customer'
                $table->string('street_number', 15); //'street number of a customer'
                $table->string('postcode', 10); //'postcode of a customer'
                $table->string('town', 55); //'town of a customer'
                $table->integer('telephone');//'telephone number of a customer'
                $table->bigInteger('mobile');//'mobile number of a customer'
                $table->string('image', 50); //'image or logo of a customer'
                $table->string('file', 50); //'file of a customer'
                $table->tinyInteger('status'); //'1 - active\n0 - inactive'

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }


    /**
     * Items table for inventory [Many to one relation with inventory table]
     */
    function products()
    {
        if (!Schema::hasTable(self::TBL_PREFIX . 'products')) {
            Schema::create(self::TBL_PREFIX . 'products', function (Blueprint $table) {
                $table->increments('id'); // autoincrement value of an product
                $table->integer('user_id')->unsign()->index(); //user id who added the product
                $table->string('number', 25)->unique();  // product
                $table->string('name', 100)->unique();  // name of an product
                $table->float('vat'); // Vat percentage applied for the product
                $table->decimal('selling_price', 8, 2); //price of an product
                $table->decimal('purchase_cost', 8, 2); //price of an product

                // created_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Inventory Table (used to record all the inventory items)
     */
    function inventory()
    {
        if (!Schema::hasTable(self::TBL_PREFIX . 'inventory')) {
            Schema::create(self::TBL_PREFIX . 'inventory', function (Blueprint $table) {
                $table->increments('id'); // autoincrement value of an product
                $table->integer('product_id')->index(); //product id
                $table->integer('user_id')->unique();  // name of an product
                $table->integer('quantity'); // quantity of an product
                $table->float('vat'); // Vat percentage applied for the product
                $table->decimal('selling_price', 8, 2); //price of an product
                $table->decimal('purchase_cost', 8, 2); //price of an product
                $table->datetime('purchase_date'); // Add time or purchased date of an product

                // created_at DATETIME
                $table->timestamps();
            });
        }
    }
}