<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class RelativeDetails extends Model {

    protected $table = 'relative_details';
    protected $fillable = ['given_name', 'surname', 'relationship_id', 'address_id', 'phone_id', 'applicant_id'];

    public $timestamps = false;

}