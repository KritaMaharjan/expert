<?php

namespace App\Http\Tenant\Accounting\Entity;

use App\Http\Tenant\Accounting\Models\Transaction as TransactionModel;

class Transaction {

    protected $amount;
    protected $description;
    protected $vat;
    protected $type;

    /**
     * @param Amount $amount
     * @param $desciption
     * @param Vat $vat
     * @param $type
     */

    function __construct(Amount $amount, $desciption, Vat $vat, $type)
    {
        $this->amount = $amount;
        $this->description = $desciption;
        $this->vat = $vat;
        $this->type = $type;
    }

    function save()
    {
        $data = [
            'amount'      => $this->amount,
            'description' => $this->description,
            'type'        => $this->type,
            'vat'         => $this->vat
        ];

        return TransactionModel::create($data);
    }

    public function __toString()
    {
        return $this->description;
    }

} 