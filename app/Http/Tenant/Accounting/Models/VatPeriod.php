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
}
