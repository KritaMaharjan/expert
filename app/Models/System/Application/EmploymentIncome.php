<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class EmploymentIncome extends Model {

    protected $table = 'employment_incomes';
    protected $fillable = ['applicant_id', 'annual_gross_income', 'pay_frequency', 'salary_crediting', 'credit_to_where', 'latest_pay_date', 'latest_payslip_period_from', 'latest_payslip_period_to', 'employment_detail_id'];

    public $timestamps = false;

}