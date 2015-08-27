<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class ApplicantAddress extends Model {

    protected $table = 'applicant_address';
    protected $fillable = ['address_id', 'applicant_id', 'iscurrent', 'address_type_id', 'live_there_since'];

    public $timestamps = false;

}