<?php
namespace App\Http\Tenant\Accounting\Libraries;

use App\Http\Tenant\Accounting\Entity\AccountCode;
use App\Http\Tenant\Accounting\Entity\Amount;
use App\Http\Tenant\Accounting\Entity\Credit;
use App\Http\Tenant\Accounting\Entity\Debit;
use App\Http\Tenant\Accounting\Entity\Transaction;
use App\Http\Tenant\Accounting\Entity\Vat;
use App\Http\Tenant\Accounting\Libraries\Entry;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Models\Tenant\Customer;

class Record {

    /*
    * Define Types of records
    */
    const BILL = 1;
    const EXPEMSE = 2;




    /* BILL RELATED TRANSACTION */

    /**
     * Send a Bill to Customer
     * @param Bill $bill
     * @param Customer $customer
     * @param $amount
     * @param $vat
     * @return array
     */
    function sendABill(Bill $bill, Customer $customer, $amount, $vat)
    {
        $vat = new Vat($vat);
        $amount = new Amount($amount);
        $amount_vat = $amount->vat($vat);
        $amount_without_vat = $amount->withoutVat($vat);
        $subledger = $customer->account();

        $entry = new Entry();
        $entry->transaction(new Transaction($amount, 'Send a bill to customer', $vat, self::BILL, $bill->id));
        $entry->debit(new Debit($amount, new AccountCode(1500), "Send a bill to customer"));
        $entry->credit(new Credit($amount_without_vat, new AccountCode(3100), "Amount with out vat"), $subledger);
        $entry->credit(new Credit($amount_vat, new AccountCode($vat->accountCode()), "Vat amount"));

        return $entry->save();
    }

    function billPayment()
    {

    }

    function billCancel()
    {

    }

    function billAsLoss()
    {

    }


    /* EXPENSE RELATED TRANSACTION */

    function createAnExpense()
    {

    }

    function expensePayment()
    {

    }

    function expenseCancel()
    {

    }




} 