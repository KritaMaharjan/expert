<?php

namespace App\Http\Tenant\Accounting\Entity;

use App\Http\Tenant\Accounting\Models\Entry;
use App\Http\Tenant\Accounting\Models\Transaction as TransactionModel;

class Debit {

    protected $account;
    protected $amount;
    protected $description;
    private $type;

    function __construct(Amount $amount, AccountCode $accountCode, $description, $subledger = null)
    {
        $this->amount = $amount;
        $this->amountCode = $accountCode;
        $this->description = $description;
        $this->type = Entry::DEBIT;
        $this->subledger = $subledger;
    }

    public function save(TransactionModel $transaction)
    {

        $data = [
            'transaction_id' => $transaction->id,
            'account_code'   => $this->amountCode,
            'amount'         => $this->amount,
            'subledger'      => $this->subledger,
            'description'    => $this->description,
            'type'           => $this->type,
        ];

        return Entry::create($data);
    }
}