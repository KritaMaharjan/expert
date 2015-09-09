<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class ApplicationApplicant extends Model {

    protected $table = 'application_applicants';
    protected $fillable = ['application_id', 'applicant_id'];

    public $timestamps = false;

}