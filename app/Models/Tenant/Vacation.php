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

    protected $fillable = ['user_id', 'vacation_days', 'sick_days','from','to'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
  
     protected $primaryKey = "id";

     function totalVacation($user_id,$type)
     {
          $details = \DB::table('fb_vacation')->where('user_id', $user_id)->get();
          $totalVacation = 0;
          if(!empty($details)){
            foreach ($details as $key => $value) {
                if($type == 'vacation_days')
                    $totalVacation += $value->vacation_days;
                elseif($type == 'sick_days')
                     $totalVacation += $value->sick_days;

              
          }

          }

          return $totalVacation;
     }

     function addVacation($request, $type)
    {
        if ($type == 'vacation_days') {
            $vacation = Vacation::create([
                'user_id'       => $request['user_id'],
                'vacation_days' => $request['leave'],
                'sick_days'     => 0,
                'from'     =>  $request['from'],
                 'from'     =>  $request['to'],
            ]);


        } elseif ($type == 'sick_days') {
            $vacation = Vacation::create([
                'user_id'       =>  $request['user_id'],
                'vacation_days' => 0,
                'sick_days'     =>  $request['leave'],
                 'from'     =>  $request['from'],
                 'from'     =>  $request['to'],

            ]);


        }


    }

     function getUserVacation($user_id){
         $details = \DB::table('fb_vacation')->where('user_id', $user_id)->get();
         return $details;

     }
 }

     ?>