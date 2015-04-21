<?php
namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_entries';


    const CREDIT = 1;
    const DEBIT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'transaction_id', 'account_code', 'description', 'amount', 'type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public $timestamps = false;
}