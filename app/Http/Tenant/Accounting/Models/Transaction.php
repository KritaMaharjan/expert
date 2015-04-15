<?php
/**
 * Created by PhpStorm.
 * User: manishg.singh
 * Date: 4/9/2015
 * Time: 5:20 PM
 */
namespace App\Http\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_transaction';


    const CREDIT = 1;
    const DEBIT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'account_code', 'subledger', 'amount', 'description', 'type', 'vat', 'payment_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    function add($entry)
    {
        $data = [
            'account_code' => $entry->account,
            'amount'       => $entry->amount,
            'description'  => $entry->description,
            'type'         => $entry->type,
            'vat'          => $entry->vat,
            'payment_date' => $entry->date
        ];
        $this->create($data);
    }


}