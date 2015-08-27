<?php
namespace App\Models\System\Property;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{

    protected $table = 'income';
    protected $fillable = ['property_id', 'type', 'weekly_rental', 'credit_to'];

    public $timestamps = false;

} 