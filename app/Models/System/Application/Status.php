<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

    protected $table = 'status';
    protected $fillable = ['name', 'description'];

    public $timestamps = false;

}