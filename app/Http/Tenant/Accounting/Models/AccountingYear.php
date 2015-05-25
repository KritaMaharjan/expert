<?php

namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingYear extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_accounting_year';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'year'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected static $current_year = null;


    public static function CurrentYear()
    {

        if(is_null(self::$current_year))
        {
            $row = self::select('id','year')->orderBy('year', 'DESC')->first();
            if (!empty($row)) {
                return $row;
            }
            else {
                AccountingYear::create(['year', date("Y")]);
            }
            //throw new \Exception('Accounting year not setup yet.');
        }

        return self::$current_year;
    }

} 