<?php
namespace App\Models\System\Log;

use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model {

    protected $table = 'application_logs';
    protected $fillable = ['application_id', 'log_id'];

    public function log()
    {
        return $this->belongsTo('App\Models\System\Log\Log', 'log_id');
    }
}