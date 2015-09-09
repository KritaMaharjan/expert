<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model {

    protected $table = 'applicants';
    protected $fillable = ['preferred_name', 'title', 'given_name', 'surname', 'dob', 'residency_status', 'years_in_au', 'marital_status', 'email', 'mother_maiden_name', 'credit_card_issue', 'issue_comments', 'driver_licence_number', 'licence_state', 'licence_expiry_date'];

    public $timestamps = false;

}