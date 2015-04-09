<?php
namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class Report extends Model {

    //change these later
    protected $table = "fb_settings";

    protected $fillable = ['name', 'value'];

    protected $primaryKey = "name";

    protected $connection = 'tenant';

}
