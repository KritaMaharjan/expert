<?php

namespace App\Http\Tenant\Accounting\Entity;

use App\Http\Tenant\Accounting\Models\AccountingYear;
use App\Http\Tenant\Accounting\Models\Transaction as TransactionModel;

class Transaction {

    protected $amount;
    protected $description;
    protected $vat;
    protected $type;

    /**
     * @param Amount $amount
     * @param $description
     * @param Vat $vat
     * @param $type
     * @param $type_id
     */

    function __construct(Amount $amount, $description, Vat $vat, $type, $type_id)
    {
        $this->amount = $amount;
        $this->description = $description;
        $this->vat = $vat;
        $this->type = $type;
        $this->type_id = $type_id;

    }

    function save()
    {
        $data = [
            'user_id'            => current_user()->id,
            'accounting_year_id' => AccountingYear::CurrentYear()->id,
            'amount'             => $this->amount,
            'description'        => $this->description,
            'vat'                => $this->vat,
            'type'               => $this->type,
            'type_id'            => $this->type_id
        ];

        return TransactionModel::create($data);
    }
} 