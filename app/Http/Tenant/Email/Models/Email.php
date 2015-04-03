<?php namespace App\Http\Tenant\Email\Models;

use App\Http\Tenant\Tasks\Models\Tasks;
use Carbon\Carbon;
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
    protected $table = 'fb_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'sender_id', 'email', 'subject', 'message', 'status', 'note', 'type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    private $email_subject;
    private $email_message;
    private $email_note;
    private $email_type;
    private $email_status;

    private $attach;
    private $to;
    private $cc;
    protected $fromName;
    protected $fromEmail;


    public function attachments()
    {
        return $this->hasMany('App\Http\Tenant\Email\Models\Attachment');
    }

    public function receivers()
    {
        return $this->hasMany('App\Http\Tenant\Email\Models\Receiver');
    }


    function scopeUser($query)
    {
        $query->where('sender_id', current_user()->id);
    }


    function scopeType($query, $type = 0)
    {
        $query->where('type', $type);
    }

    function scopeLatest($query)
    {
        $query->orderBy('created_at', 'DESC');
    }

    /**
     * @return array|bool
     */
    function send()
    {
        $this->setTo(Request::input('email_to'));
        $this->setCc(Request::input('email_cc'));
        $this->email_subject = Request::input('subject');
        $this->email_message = Request::input('message');
        $this->attach = Request::input('attach');
        $this->email_note = Request::input('note');
        $this->email_type = Request::input('type');
        $this->email_status = Request::input('status');
        $this->fromName = current_user()->display_name;
        $this->fromEmail = current_user()->smtp->email;
        // Send email

        $this->fire();


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


        $email['to'] = Request::input('email_to');
        $email['created_at'] = email_date($email['created_at']);

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
        $email->message = $this->email_message;
        $email->subject = $this->email_subject;
        $email->sender_id = current_user()->id;
        $email->note = $this->email_note;
        $email->type = $this->email_type;
        $email->status = $this->email_status;
        $email->save();

        if($this->email_status == 5)
            $this->createTask();

        return $email->toArray();
    }

    function createTask()
    {
        Tasks::create([
            'subject' => $this->email_subject,
            'body' => $this->email_message,
            'due_date' => Carbon::today()
        ]);
    }

    function fire()
    {
        $send = new \stdClass();
        $send->fromEmail = $this->fromEmail;
        $send->fromName = $this->fromName;
        $send->to = $this->to;
        $send->subject = $this->email_subject;
        $send->cc = $this->cc;
        $send->attach = $this->getAttachment();

        $param = [
            'content'    => $this->email_message,
            'heading'    => 'FastBooks',
            'subheading' => 'All your business in one space',
        ];

        \Mail::send('template.master', $param, function ($message) use ($send) {
            $message->from($send->fromEmail, $send->fromName);
            $message->to($send->to);
            $message->subject($send->subject);

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

    function getCustomerEmail($user_id,$perpage)
    {
        $details = DB::table('fb_email_receivers')
            ->join('fb_emails', 'fb_email_receivers.email_id', '=', 'fb_emails.id')
            ->where('fb_email_receivers.customer_id', $user_id)
            ->orderBy('fb_email_receivers.id', 'desc')
            ->paginate($perpage);
            

        foreach ($details as $key => &$value) {
            $attachment = \DB::table('fb_attachments_email')->where('email_id', $value->email_id)->get();
            $receiver = \DB::table('fb_email_receivers')->where('email_id', $value->email_id)->get();
            $value->attachment = $attachment;
            $value->receiver = $receiver;
        }

        return $details;
    }

    function getSearchEmail($user_id,$perpage,$search_option=NULL){

        if(!is_null($search_option)){
             $details = DB::table('fb_email_receivers')
            ->join('fb_emails', 'fb_email_receivers.email_id', '=', 'fb_emails.id')
            ->where('fb_email_receivers.customer_id', $user_id)
            //->like('%'.$search_option.'%')
             ->where('fb_email_receivers.email', 'like', '%'.$search_option.'%')
            ->orderBy('fb_email_receivers.id', 'desc')
            ->paginate($perpage);

            // $details->setBaseUrl('custom/url');
            

        foreach ($details as $key => &$value) {
            $attachment = \DB::table('fb_attachments_email')->where('email_id', $value->email_id)->get();
            $receiver = \DB::table('fb_email_receivers')->where('email_id', $value->email_id)->get();
            $value->attachment = $attachment;
            $value->receiver = $receiver;
        }

        return $details;

        }
       

    }

}

?>