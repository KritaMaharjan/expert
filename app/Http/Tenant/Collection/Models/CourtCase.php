<?php

namespace App\Http\Tenant\Collection\Models;

use Illuminate\Database\Eloquent\Model;

class CourtCase extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_court_case';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'bill_id', 'pdf', 'email', 'information'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


}