<?php

namespace App\Http\Tenant\Email\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_email_attachments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'email_id', 'file'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public $timestamps = false;


    function add($email, $files)
    {
        $data = array();
        if (is_array($files)) {
            foreach ($files as $file) {
                $data[] = [
                    'email_id' => $email['id'],
                    'file'     => $file
                ];
            }
        } else {
            $data = [
                'email_id' => $email['id'],
                'file'     => $files
            ];
        }


        return $this->insert($data);

    }


}