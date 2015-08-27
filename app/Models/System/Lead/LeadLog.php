<?php
namespace App\Models\System\Lead;

use Illuminate\Database\Eloquent\Model;

class LeadLog extends Model {

    protected $table = 'client_lead_logs';
    protected $fillable = ['ex_lead_id', 'log_id'];
}