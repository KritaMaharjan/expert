<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class Dependent extends Model {

    protected $table = 'dependents';
    protected $fillable = ['age_of_dependents', 'applicant_id'];

    public $timestamps = false;

}