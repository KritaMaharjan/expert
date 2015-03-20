<?php namespace App\Http\Tenant\Email\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\Tenant\Email\Models\Receiver;
use App\Http\Tenant\Email\Models\Attachment;


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
    protected $fillable = ['id', 'sender_id', 'email', 'message', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    private $subject;
    private $message;
    private $note;
    private $attach;
    private $to;
    private $cc;
    private $fromName;
    private $fromEmail;

    function scopeUser($query)
    {
        $query->where('sender_id', current_user()->id);
    }

    /**
     * @return array|bool
     */
    function send()
    {
        $this->setTo(Request::input('email_to'));
        $this->setCc(Request::input('email_cc'));
        $this->subject = Request::input('subject');
        $this->message = Request::input('message');
        $this->attach = Request::input('attach');
        $this->note = Request::input('note');
        $this->fromName = 'Manish Gopal Singh';
        $this->fromEmail = 'manish.aucio@gmail.com';
        // Send email
        //  $this->fire();


        DB::beginTransaction();

        // save email
        try {
            $email = $this->saveEmail();
        } catch (\PDOException $e) {
            DB::rollback();
            print_r($e->errorInfo[2]);

            return false;
        }

        // save attachment
        try {
            $attached = $this->getAttachment(false);
            $attachment = new Attachment();
            $attachment->add($email, $attached);
        } catch (\PDOException $e) {
            DB::rollback();
            print_r($e->errorInfo[2]);

            return false;
        }

        //save receipt
        try {
            $receiver = new Receiver();
            $receiver->add($email['id'], $this->to, $this->cc);
        } catch (\PDOException $e) {
            DB::rollback();
            print_r($e->errorInfo[2]);

            return false;
        }
        DB::commit();

        return $email;
    }

    function setTo($emailString)
    {
        $this->to = $this->getEmails($emailString);
    }

    function setCc($emailString)
    {
        $this->cc = $this->getEmails($emailString);
    }

    function getAttachment($fullPath = true)
    {
        $fileRe = array();
        if (!empty($this->attach) AND count($this->attach) > 0) {
            foreach ($this->attach as $file) {

                if ($fullPath)
                    $fileRe[] = asset('uploads/attachment/' . $file);
                else
                    $fileRe[] = $file;

            }
        }

        return $fileRe;
    }

    function getEmails($raw)
    {
        $emails = explode(';', $raw);
        $emails = array_map('trim', $emails);
        $emails = array_filter($emails);
        $re = array();
        foreach ($emails as $k => $email) {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $re[] = $email;
            }
        }

        return $re;
    }


    function saveEmail()
    {
        $email = new Email();
        $email->message = $this->message;
        $email->subject = $this->subject;
        $email->sender_id = current_user()->id;
        $email->note = $this->note;
        $email->status = 1;
        $email->save();

        return $email->toArray();
    }


    function fire()
    {
        $send = new \stdClass();
        $send->fromEmail = $this->fromEmail;
        $send->fromName = $this->fromName;
        $send->to = $this->to;
        $send->cc = $this->cc;
        $send->attach = $this->getAttachment();

        $param = [
            'content'    => $this->message,
            'heading'    => 'FastBooks',
            'subheading' => 'All your business in one space',
        ];

        \Mail::send('template.master', $param, function ($message) use ($send) {
            $message->from($send->fromEmail, $send->fromName);
            $message->to($send->to);
            if (!empty($send->cc)) {
                $message->cc($send->cc);
            }

            if (!empty($send->attach)) {
                foreach ($send->attach as $k => $attach) {
                    $message->attach($attach);
                }
            }

        });

    }

}

?>