<?php
namespace App\Http\Tenant\Collection\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_collection';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'bill_id', 'step', 'file'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

} 