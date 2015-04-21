<?php

namespace App\Http\Tenant\Accounting\Libraries;

use App\Http\Tenant\Accounting\Entity\Credit;
use App\Http\Tenant\Accounting\Entity\Debit;
use App\Http\Tenant\Accounting\Entity\Transaction;

Class Entry {

    protected $transaction;
    protected $debit;
    protected $credit;

    function __construct()
    {
        $this->flush();
    }

    /**
     * Set Transaction (one transaction per entry)
     * @param Transaction $transaction
     */
    public function transaction(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Add multiple debit entry
     * @param Debit $debit
     */
    public function debit(Debit $debit)
    {
        $this->debit[] = $debit;
    }

    /**
     * Add Multiple multiple credit entry
     * @param Credit $credit
     */
    public function credit(Credit $credit)
    {
        $this->credit[] = $credit;
    }


    /**
     * Save Transaction and entries
     */
    public function save()
    {
        $debitArr = [];
        $creditArr = [];
        $transaction = null;

        if (!empty($this->transaction) AND !empty($this->credit) AND !empty($this->debit)) {

            \DB::transaction(function () use(&$debitArr, &$creditArr, &$transaction) {

                $transaction = $this->transaction->save();

                foreach ($this->debit as $debit) {
                    $debitArr[] = $debit->save($transaction);
                }

                foreach ($this->credit as $credit) {
                    $creditArr[] = $credit->save($transaction);
                }
            });

            $this->flush();

            return ['transaction' => $transaction, 'debit' => $debitArr, 'credit' => $creditArr];

        }

        return [];
    }

    /**
     * reset transaction and entries;
     */
    private function flush()
    {
        $this->transaction = null;
        $this->credit = [];
        $this->debit = [];
    }


}