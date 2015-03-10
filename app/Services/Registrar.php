<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			//'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'status' => 0 //pending activation
			//'password' => bcrypt($data['password']),
		]);

		//$this->createdb($data['username']);

		return $user;
	}

	public function createdb($dbname)
    {
        $prefix = 'laraapp_';
        $dbname = $prefix.$dbname;

        DB::statement( 'CREATE DATABASE IF NOT EXISTS '.$dbname);

        configureConnectionByName( $dbname, 'root', 'root');

        if(! Schema::hasTable( 'customer' )) {

            Schema::create('customer', function($t) {
                // auto increment id (primary key)
                $t->increments('id');

                $t->string('name');
                $t->integer('age')->nullable();
                $t->boolean('active')->default(1);
                $t->integer('role_id')->unsigned();
                $t->text('bio');

                // created_at, updated_at DATETIME
                $t->timestamps();
            });
        }


    }


}
