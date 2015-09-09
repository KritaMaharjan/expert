<?php
namespace App\Models\System\Log;

use Illuminate\Database\Eloquent\Model;

class LeadLog extends Model {

    protected $table = 'ex_lead_logs';
    protected $fillable = ['ex_lead_id', 'log_id'];

    public function log()
    {
        return $this->belongsTo('App\Models\System\Log\Log', 'log_id');
    }
}