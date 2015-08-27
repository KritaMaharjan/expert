<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class LivingExpense extends Model {

    protected $table = 'living_expense';
    protected $fillable = ['monthly_living_expense', 'applicant_id'];

    public $timestamps = false;

}