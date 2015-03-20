<?php namespace App\Http\Tenant\Invoice\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBill extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_product_bill';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'bill_id', 'quantity', 'price', 'vat', 'currency', 'total'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
