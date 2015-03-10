<?php namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class PostalTown extends Model {

    protected $table = 'fb_postal_towns';

    protected $fillable = ['postal_code', 'town'];

    protected $primaryKey = "name";

    protected $connection = 'tenant';

}
