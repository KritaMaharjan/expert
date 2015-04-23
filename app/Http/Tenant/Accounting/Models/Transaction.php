<?php
/**
 * Created by PhpStorm.
 * User: manishg.singh
 * Date: 4/9/2015
 * Time: 5:20 PM
 */
namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_transactions';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'description', 'amount', 'type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        User::creating(function($user)
        {

        });
    }
}