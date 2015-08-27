<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class ApplicantPhone extends Model {

    protected $table = 'applicant_phone';
    protected $fillable = ['phones_id', 'is_current', 'applicants_id'];

    public $timestamps = false;

    /**
     * Get the phone record associated.
     */
    public function phone()
    {
        return $this->belongsTo('App\Models\System\Profile\Phone', 'phones_id');
    }
}