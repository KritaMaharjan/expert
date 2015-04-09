<?php

namespace APP\Http\Tenant\Email\Controllers;

use App\Fastbooks\Libraries\Mailbox\EmailReader;
use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Email\Models\IncomingEmail;

class IncomingEmailController extends BaseController {

    /*protected $host = 'imap.gmail.com';
    protected $host_email = 'manish.alucio@gmail.com';
    protected $password = '@sdf@sdf';*/

    protected $host = 'alucio.com';
    protected $host_email = 'krita@alucio.com';
    protected $password = '@1uc!0';

    function __construct(IncomingEmail $incomingEmail)
    {
        parent::__construct();

        $this->incomingEmail = $incomingEmail;
    }

    function inbox()
    {
        $this->readUserEmail();
        $data['action'] = 'add';
        return view('tenant.email.index', $data);
    }

    function listing()
    {
        $type = $this->request->input('type');
        $data['type'] = $type = ($type == 1) ? $type : 0;
        $data['per_page'] = $per_page = 5;
        $data['mails'] = $this->incomingEmail->orderBy('received_at', 'DESC')->type($type)->paginate($per_page);

        return view('tenant.email.list', $data);
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
                return $this->recordEmail($data);
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
        dd($data);
        return $this->success(array('mail' => $data));
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