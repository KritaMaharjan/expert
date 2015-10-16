<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model {

    protected $table = 'application_status';
    protected $fillable = ['date_created', 'updated_by', 'application_id', 'status_id'];

    public $timestamps = false;

    function status()
    {
        return $this->belongsTo('App\Models\System\Application\Status', 'status_id');
    }

}