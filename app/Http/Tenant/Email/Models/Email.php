<?php namespace App\Http\Tenant\Email\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Email extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_email';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'sender_id', 'email', 'receiver_id', 'message', 'status', 'attachment'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    function add(Request $request)
    {
        $email_to = $request->input('email_to');
        $email_cc = $request->input('email_cc');
        $email_bcc = $request->input('email_bcc');
         
         if(!empty($email_to)){
            foreach ($email_to as $email) {
                $insert_email = Email::create([
                'sender_id'    => current_user()->id,
                //'receiver_id'      => $request->input(''),
                'message' => $request->input('message'),
                'status' =>  $request->input('status'),
                'email' => $email,
                'attachment' =>  $request->input('attachment'),
            
            ]);
        }

        }

        if(!empty($email_cc)){
            foreach ($email_cc as $email) {
                $insert_email = Email::create([
                'sender_id'    => current_user()->id,
                //'receiver_id'      => $request->input(''),
                'message' => $request->input('message'),
                'status' =>  $request->input('status'),
                'email' => $email,
                'attachment' =>  $request->input('attachment'),
            
            ]);
        }

        }

        if(!empty($email_bcc)){
            foreach ($email_bcc as $email) {
                $insert_email = Email::create([
                'sender_id'    => current_user()->id,
                //'receiver_id'      => $request->input(''),
                'message' => $request->input('message'),
                'status' =>  $request->input('status'),
                'email' => $email,
                'attachment' =>  $request->input('attachment'),
            
            ]);
        }

        }



       

        


    
    }
}

?>