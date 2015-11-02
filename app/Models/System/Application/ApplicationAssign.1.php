<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class ApplicationAssign extends Model {

    protected $table = 'application_assign';
    protected $fillable = ['description', 'assign_to', 'application_id', 'status', 'assigned_date', 'assigned_by', 'accepted_date'];

    public $timestamps = false;

    // Get the details of sales person assigned
    function assignedTo()
    {
        return $this->belongsTo('App\Models\System\User\User', 'assign_to');
    }
}