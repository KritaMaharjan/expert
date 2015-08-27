<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class EmploymentDetails extends Model {

    protected $table = 'employment_details';
    protected $fillable = ['employment_type', 'job_title', 'starting_date', 'business_name', 'abn', 'contact_person', 'contact_person_job_title', 'contact_number', 'address_id', 'applicant_id', 'is_current'];

    public $timestamps = false;

}