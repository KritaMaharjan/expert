<?php
namespace App\Models\System\Log;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {

    protected $table = 'logs';
    protected $fillable = ['comment', 'added_by', 'emailed_to', 'email'];

    public function log()
    {
        return $this->hasOne('App\Models\System\Log\Leadlog', 'log_id');
    }
}