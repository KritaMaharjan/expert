<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class RentExpense extends Model {

    protected $table = 'rent_expenses';
    protected $fillable = ['weekly_rent_expense', 'applicant_id'];

    public $timestamps = false;

}