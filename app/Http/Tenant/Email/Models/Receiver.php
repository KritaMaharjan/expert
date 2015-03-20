<?php

namespace App\Http\Tenant\Email\Models;


use Illuminate\Database\Eloquent\Model;

class Receiver extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_email_receivers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'email_id', 'customer_id', 'type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public $timestamps = false;


    public function email()
    {
        return $this->belongsTo('App\Http\Tenant\Email\Models\Email');
    }


    public function add($email_id, $to, $cc)
    {
        $emails = $to;
        $data = array();
        foreach ($emails as $email) {
            $data[] = [
                'email_id'    => $email_id,
                'email'       => $email,
                'customer_id' => $this->getCustomerByEmail($email),
                'type'        => 1  // To type
            ];
        }

        $emails = $cc;
        foreach ($emails as $email) {
            $data[] = [
                'email_id'    => $email_id,
                'email'       => $email,
                'customer_id' => $this->getCustomerByEmail($email),
                'type'        => 2  // CC type
            ];
        }

        $this->insert($data);
    }

    function getCustomerByEmail($email)
    {
        return '3';
    }

} 