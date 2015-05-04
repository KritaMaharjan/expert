<?php
/**
 * Created by PhpStorm.
 * User: manishg.singh
 * Date: 4/9/2015
 * Time: 5:20 PM
 */
namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

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
    protected $fillable = ['id', 'user_id', 'accounting_year_id', 'amount', 'description', 'vat', 'type', 'type_id'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function entries()
    {
        return $this->hasMany('App\Http\Tenant\Accounting\Models\Entry');
    }

    function getPagination()
    {
        $q = $this->with('entries');

        $from = Input::get('from');
        $to = Input::get('to');
        $type = Input::get('type');

        if ($type != '') {
            $q->where('type', $type);
        }

        if ($from != '') {
            $q->where('created_at', '>=',$from);
        }

        if ($to != '') {
            $q->where('created_at', '<' , date('Y-m-d', strtotime($to . '+1day')));
        }

        return $q->paginate(2);
    }


}