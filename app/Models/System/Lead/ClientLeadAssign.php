<?php
namespace App\Models\System\Lead;

use Illuminate\Database\Eloquent\Model;

class ClientLeadAssign extends Model {

    protected $table = 'ex_client_leads_assign';
    protected $fillable = ['ex_leads_id', 'meeting_datetime', 'meeting_place', 'description', 'assign_to', 'status'];

    public $timestamps = false;

    // Get the details of sales person assigned
    function assignedTo()
    {
        return $this->belongsTo('App\Models\System\User\User', 'assign_to');
    }
}