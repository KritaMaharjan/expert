<?php

namespace APP\Http\Tenant\Email\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Email\Models\Attachment;
use App\Http\Tenant\Email\Models\Receiver;
use App\Models\Tenant\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Tenant\Email\Models\Email;
use App\Http\Tenant\Email\Models\IncomingEmail;
use App\Fastbooks\Libraries\Mailbox\EmailReader;

class EmailController extends BaseController {

    protected $request;
    protected $email;
    protected $attachment;
    protected $receiver;
    protected $upload_path = './assets/uploads/';
    protected $host = 'alucio.com';
    protected $host_email = 'krita@alucio.com';
    protected $password = '@1uc!0';
    protected $port = 25;

    function __construct(Request $request, Email $email, Attachment $attachment, Receiver $receiver, IncomingEmail $incomingEmail)
    {

        parent::__construct();
        $this->request = $request;
        $this->email = $email;
        $this->attachment = $attachment;
        $this->receiver = $receiver;
        $this->incomingEmail = $incomingEmail;
    }

    function index()
    {
        $action = 'add';
        return view('tenant.email.index', compact('action'));
    }

    function customerSearch(Customer $customer)
    {
        $query = $this->request->input('term');
        $details = $customer->select('id', 'name as label', 'email as value')->where('email', 'LIKE', '%' . $query . '%')->orWhere('name', 'LIKE', '%' . $query . '%')->get()->toArray();

        return \Response::JSON($details);
    }

    function attach()
    {
        if ($return = tenant()->folder('attachment')->upload('file')) {
            return $this->success($return);
        }

        return $this->fail(['error' => 'File upload failed']);
    }


    function send()
    {
        $validator = $this->validateComposer();
        if ($validator->fails()) {
            return $this->fail(['errors' => $validator->messages()]);
        }

        if ($email = $this->email->send()) {
            return $this->success($email);
        }

        return $this->fail(['error' => 'Could not send email at this moment. Please try again later']);
    }


    function validateComposer()
    {
        $rules = [
            'email_to' => 'required|validArrayEmail',
            'email_cc' => 'validArrayEmail',
            'subject'  => 'required',
            'message'  => 'required',
            'status'   => 'required'
        ];
        $validator = \Validator::make($this->request->all(), $rules);

        return $validator;
    }


    function get()
    {
        $id = $this->request->route('id');
        $mail = $this->email->with('attachments', 'receivers')->where('id', $id)->user()->first()->toArray();

        $to = "";
        $cc = "";
        foreach ($mail['receivers'] as $re) {
            if ($re['type'] == 1)
                $to .= $re['email'] . ';';
            else
                $cc .= $re['email'];
        }

        foreach ($mail['attachments'] as &$at) {
            unset($at['id']);
            unset($at['email_id']);
        }


        unset($mail['receivers']);
        $mail['to'] = $to;
        $mail['cc'] = $cc;

        $display_name = current_user()->display_name;
        $email = current_user()->smtp->email;

        $message = "
<br/>
<br/>
<br/>
<br/>
<hr/>
<strong>From:</strong> " . $display_name . "[mailto:" . $email . "]<br/>
<strong>Sent:</strong> " . date('D, F d, Y, h:i A') . "<br/>
<strong>To:</strong> " . $mail['to'] . "<br/>";

        if ($mail['cc'] != '')
            $message .= "
<strong>Cc:</strong> " . $mail['to'];

        $message .= "
<strong>Subject:</strong> " . $mail['subject'] . "

" . $mail['message'];

        $mail['message'] = $message;
        $data['mail'] = $mail;

        return $this->success($data);
    }


    function show()
    {
        $id = $this->request->route('id');
        $folder = $this->request->input('folder');

        if($folder == 0)
            $mail = $this->email->with('attachments', 'receivers')->where('id', $id)->user()->first();
        else
            $mail = $this->incomingEmail->where('id', $id)->user()->first();
        return view('tenant.email.view', compact('mail'))->with('folder', $folder);
    }

    function listing()
    {
        $type = $this->request->input('type');
        $data['type'] = $type = ($type == 1) ? $type : 0;
        $data['per_page'] = $per_page = 10;
        $folder = $this->request->input('folder');
        $data['folder'] = $folder;

        if($folder == 0)
            $data['mails'] = $this->email->user()->orderBy('created_at', 'DESC')->type($type)->with('attachments', 'receivers')->paginate($per_page);
        else {
            $this->readUserEmail();
            $data['mails'] = $this->incomingEmail->user()->orderBy('created_at', 'DESC')->type($type)->paginate($per_page);
        }
        return view('tenant.email.list', $data);
    }

    function deleteAttachment()
    {
        if ($this->request->ajax()) {
            $file = $this->request->input('file');
            $destinationPath = $this->upload_path . $file;
            unlink($destinationPath);

            return $this->success(['message' => 'File deleted']);
        }

        return $this->fail(['error' => 'Something went wrong. Please try again later']);
    }

    function delete()
    {
        if ($this->request->ajax()) {
            $id = $this->request->route('id');
            $email = $this->email->where('id', $id)->user()->first();
            if (!empty($email)) {
                if ($email->delete()) {

                    $this->attachment->where('email_id', $id)->delete();
                    $this->receiver->where('email_id', $id)->delete();

                    return $this->success(['message' => 'Email deleted Successfully']);
                }
            }

            return $this->fail(['error' => 'Something went wrong. Please try again later']);
        }

    }


     function search_email(){
        
        $search_option = $this->request->input('search_option');
        $user_id = $this->request->input('user_id');
        $perpage = 10;
        $mails = $this->email->getSearchEmail($user_id,$search_option);
         
        return view('tenant.customer.emailList', compact('mails'));
     }


    function readUserEmail()
    {
        $user = current_user();
        $smtp = (object)$user->profile->smtp;
        $validSmtp = $this->validateSmtp($smtp);
        $validSmtp = true;
        if ($validSmtp === true) {
            //$mailbox = new EmailReader($user->smtp->incoming_server, $user->smtp->email, $user->smtp->password, $user->smtp->port);
            $mailbox = new EmailReader($this->host, $this->host_email, $this->password, 993);

            if ($mailbox->connect()) {
                $data = $mailbox->read($user->profile->email_sync_at);
                $this->recordEmail($data);
            } else {
                return $this->fail(array('error' => $mailbox->error()));
            }
        }
        return $this->fail(array('error' => $validSmtp));
    }

    private function recordEmail($data)
    {
        if($data)
            $this->incomingEmail->saveEmail($data);
    }

    private function validateSmtp($smtp)
    {
        if (empty($smtp)) {
            return lang('Please configure SMTP.');
        }
        if (!isset($smtp->email) || $smtp->email == '') {
            return lang('Email is missing');
        }

        if (!isset($smtp->incoming_server) || $smtp->incoming_server == '') {
            return lang('Incoming Server is missing');
        }

        if (!isset($smtp->password) || $smtp->password == '') {
            return lang('Password is missing');
        }

        if (!isset($smtp->port) || $smtp->port == '') {
            return lang('Port is missing');
        }

        return true;
    }
}