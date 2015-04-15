<?php

namespace App\Http\Tenant\Accounting\Libraries;

use App\Http\Tenant\Models\Transaction;
use Config;

Class Entry {

    protected $codes;

    function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->setCode();
    }


    function run()
    {
        $this->sendABill(001, 1500, 15);
    }


    function setCode()
    {
        $this->codes = Config::get('accounts.codes');
    }

    function getCode($code = null)
    {
        return is_null($code) ? $this->codes : $this->codes[$code];
    }

    function sendABill($customerAccount, $amount, $vat)
    {
        $vat_amount = ($amount * $vat / 100);
        $amount_without_vat = $amount - $vat_amount;
        $debitAccount = 1500 . $customerAccount;

        // Debit Transaction
        $this->debit($debitAccount, $amount, $vat, 'Send a bill to customer');

        // Credit Transaction
        $creditAccount = 3100;
        $this->credit($creditAccount, $amount_without_vat, $vat, 'Amount with out vat');
        $this->credit($this->getVatAccount($vat), $vat_amount, $vat, 'Vat amount');
    }


    function getVatAccount($per = null)
    {
        $vat = Config::get('accounts.vat');

        return is_null($vat) ? $vat : isset($vat[$per]) ? $vat[$per] : null;
    }


    private function debit($account, $amount, $vat, $note = null)
    {
        $debit = new \stdClass();
        $debit->type = Transaction::DEBIT;
        $debit->amount = $amount;
        $debit->account = $account;
        $debit->description = $note;
        $debit->vat = $vat;
        $debit->payment_date = date('y-m-d');

        $this->transaction->add($debit);

    }


    private function credit($account, $amount, $note)
    {
        $credit = new \stdClass();
        $credit->type = Transaction::CREDIT;
        $credit->amount = $amount;
        $credit->account = $account;
        $credit->description = $note;
        $credit->vat = $vat;
        $credit->payment_date = date('y-m-d');

        $this->transaction->add(Transaction::DEBIT, $account, $amount, $note);
    }


}