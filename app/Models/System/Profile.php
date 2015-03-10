<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_name', 'company_number', 'user_id', 'entity_type', 'vat_rule', 'acc_number', 'address', 'postal_code', 'country', 'swift_num', 'iban'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
} 