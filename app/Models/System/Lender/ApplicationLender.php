<?php
namespace App\Models\System\Lender;

use Illuminate\Database\Eloquent\Model;

class ApplicationLender extends Model {

    protected $table = 'application_lenders';
    protected $fillable = ['application_id', 'lender_id', 'description'];

    public $timestamps = false;

}