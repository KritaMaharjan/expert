<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_vacation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['user_id', 'vacation_days', 'sick_days'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
  
     protected $primaryKey = "id";

     function totalVacation($user_id)
     {
          $details = \DB::table('fb_vacation')->where('user_id', $user_id)->get();
          $totalVacation = 0;
          if(!empty($details)){
            foreach ($details as $key => $value) {
            $totalVacation += $value->vacation_days;
              
          }

          }

          return $totalVacation;
     }
 }

     ?>