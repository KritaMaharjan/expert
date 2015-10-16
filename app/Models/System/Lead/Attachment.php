<?php
namespace App\Models\System\Lead;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model {

    protected $table = 'attachments';
    protected $fillable = ['lead_id', 'filename', 'uploaded_date', 'added_by_users_id'];

    public $timestamps = false;
}