<?php

namespace App\Http\Tenant\Accounting\Entity;

use App\Http\Tenant\Accounting\Models\Entry;
use App\Http\Tenant\Accounting\Models\Transaction as TransactionModel;

class Credit {

    protected $account;
    protected $amount;
    protected $description;
    private $type;

    function __construct(Amount $amount, AccountCode $accountCode, $description, $subledger = null)
    {
        $this->amount = $amount;
        $this->amountCode = $accountCode;
        $this->description = $description;
        $this->type = Entry::CREDIT;
        $this->subledger = $subledger;

    }


    /**
     * @param TransactionModel $transaction
     * @return static
     */
    public function save(TransactionModel $transaction)
    {
        $data = [
            'transaction_id' => $transaction->id,
            'account_code'   => $this->amountCode,
            'amount'         => $this->amount,
            'description'    => $this->description,
            'subledger'      => $this->subledger,
            'type'           => $this->type,
        ];

        return Entry::create($data);
    }
}