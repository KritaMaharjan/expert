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
            $row = self::select('year')->orderBy('year', 'DESC')->first();
            if ($row) {
                return $row->year;
            }

            return false;
        }

        return self::$current_year;
    }

} 