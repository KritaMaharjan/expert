<?php

namespace APP\Http\Tenant\Customer\Controllers;

use App\Fastbooks\Libraries\Mailbox\EmailReader;
use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Email\Models\Attachment;
use App\Http\Tenant\Email\Models\Receiver;
use App\Models\Tenant\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Tenant\Email\Models\Email;
use App\Http\Tenant\Customer\Models\CustomerCard;


class CustomerCardController extends BaseController {

    protected $request;
    protected $email;
    protected $attachment;
    protected $receiver;
    protected $customerCard;
    protected $upload_path = './assets/uploads/';


    function __construct(Request $request, Email $email, Attachment $attachment, Receiver $receiver,CustomerCard $customerCard)
    {

        parent::__construct();
        $this->request = $request;
        $this->email = $email;
        $this->attachment = $attachment;
        $this->receiver = $receiver;
        $this->customerCard = $customerCard;

    }

    function listing()
    {
        
    }
}
?>