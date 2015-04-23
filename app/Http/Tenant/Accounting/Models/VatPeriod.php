<?php

namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class VatPeriod extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_vat_period';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'period', 'months', 'status', 'sent_date', 'paid_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function getMonth($period)
    {
        switch ($period)
        {
            case 1:
                return [01, 02];
            case 2:
                return [03, 04];
            case 3:
                return [5, 6];
            case 4:
                return [7, 8];
            case 5:
                return [9, 10];
            case 6:
                return [11, 12];
        }
        return false;
    }
}
