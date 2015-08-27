<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model {

    protected $table = 'relationships';
    protected $fillable = ['name', 'description'];

    public $timestamps = false;

}