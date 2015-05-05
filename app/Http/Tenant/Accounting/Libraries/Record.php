<?php
namespace App\Http\Tenant\Accounting\Libraries;

use App\Http\Tenant\Accounting\Entity\AccountCode;
use App\Http\Tenant\Accounting\Entity\Amount;
use App\Http\Tenant\Accounting\Entity\Credit;
use App\Http\Tenant\Accounting\Entity\Debit;
use App\Http\Tenant\Accounting\Entity\Transaction;
use App\Http\Tenant\Accounting\Entity\Vat;
use App\Http\Tenant\Accounting\Libraries\Entry;
use App\Http\Tenant\Accounting\Models\Expense;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Http\Tenant\Supplier\Models\Supplier;
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
     * ------------------------
     * Debit: 1500+subledger full amount including VAT
     * Credit: 3010 the amount without VAT included:
     * Credit 2701(if 25% VAT)  with the VAT amount
     * ---------------------------------------------
     * @param Bill $bill
     * @param Customer $customer
     * @param $amount
     * @param $vat
     * @return array
     */
    public static function sendABill(Bill $bill, Customer $customer, $amount, $vat)
    {
        $vat = new Vat($vat);
        $amount = new Amount($amount);
        $amount_vat = $amount->vat($vat);
        $amount_without_vat = $amount->withoutVat($vat);

        // initialised entry object
        $entry = new Entry();

        //Create a transaction
        $transaction_description = "Send a bill to customer";
        $entry->transaction(new Transaction($amount, $transaction_description, $vat, self::BILL, $bill->id));
        // debit customer for sales
        $debit1_description = $customer->name();
        $debit1_account_code = new AccountCode(1500);
        $subledger = $customer->account();
        $entry->debit(new Debit($amount, $debit1_account_code, $debit1_description, $subledger));

        // Credit amount without vat
        $credit1_account_code = new AccountCode(3010);
        $credit1_description = "Amount without Vat";
        $entry->credit(new Credit($amount_without_vat, $credit1_account_code, $credit1_description));

        // Credit Vat amount
        $credit2_account_code = new AccountCode($vat->accountCode());
        $credit2_description = "Vat Amount";
        $entry->credit(new Credit($amount_vat, $credit2_account_code, $credit2_description));


        // finally save everything
        return $entry->save();
    }

    /**
     * Pay a bill
     * --------------------------
     * Debit 1920 (bank account)
     * credit 1500+sub-ledger.
     * --------------------------
     * @param Bill $bill
     * @param Customer $customer
     * @param $amount
     * @return array
     */
    public static function billPayment(Bill $bill, Customer $customer, $amount)
    {
        $amount = new Amount($amount);

        // initialised entry object
        $entry = new Entry();

        //Create a transaction
        $transaction_description = "Bill is paid";
        $entry->transaction(new Transaction($amount, $transaction_description, null, self::BILL, $bill->id));

        // Debit Bank account
        $debit1_description = 'Bank Account';
        $debit1_account_code = new AccountCode(1920);
        $entry->debit(new Debit($amount, $debit1_account_code, $debit1_description));

        // Credit Customer account
        $credit2_account_code = new AccountCode(1500);
        $credit2_description = $customer->name();
        $subledger = $customer->account();
        $entry->credit(new Credit($amount, $credit2_account_code, $credit2_description, $subledger));

        // finally save everything
        return $entry->save();

    }

    /**
     * Credit A Bill
     * --------------------------
     * Debit 2701 Tax amount
     * Debit 3000 Without tax
     * Credit 1500 + subledger cutomer account
     * --------------------------
     * @param Bill $bill
     * @param Customer $customer
     * @param Amount $amount
     * @param $vat
     * @return array
     */
    public static function billCredit(Bill $bill, Customer $customer, Amount $amount, $vat)
    {
        $vat = new Vat($vat);
        $amount = new Amount($amount);
        $amount_vat = $amount->vat($vat);
        $amount_without_vat = $amount->withoutVat($vat);

        // initialised entry object
        $entry = new Entry();

        //Create a transaction
        $transaction_description = "Credit a Bill";
        $entry->transaction(new Transaction($amount, $transaction_description, $vat, self::BILL, $bill->id));

        // Debit Amount without vat
        $credit1_account_code = new AccountCode(3000);
        $credit1_description = "Amount without Vat";
        $entry->debit(new Debit($amount_without_vat, $credit1_account_code, $credit1_description));

        // Debit Vat amount
        $credit2_account_code = new AccountCode($vat->accountCode());
        $credit2_description = "Vat Amount";
        $entry->debit(new Debit($amount_vat, $credit2_account_code, $credit2_description));

        // credit  a customer
        $debit1_description = $customer->name();
        $debit1_account_code = new AccountCode(1500);
        $subledger = $customer->account();
        $entry->credit(new Credit($amount, $debit1_account_code, $debit1_description, $subledger));

        // finally save everything
        return $entry->save();

    }

    /**
     * When bill is loss
     * ----------------------------
     * 7830              +Amount
     * 1500+subledger    -Amount
     * ---------------------------
     * @param Bill $bill
     * @param Customer $customer
     * @param Amount $amount
     * @return array
     */
    public static function billAsLoss(Bill $bill, Customer $customer, $amount)
    {
        $amount = new Amount($amount);

        // initialised entry object
        $entry = new Entry();

        //Create a transaction
        $transaction_description = "Bill is loss";
        $entry->transaction(new Transaction($amount, $transaction_description, null, self::BILL, $bill->id));

        // Debit Amount without vat
        $credit1_account_code = new AccountCode(7830);
        $credit1_description = "Loss Amount";
        $entry->debit(new Debit($amount, $credit1_account_code, $credit1_description));

        // credit  a customer
        $debit1_description = $customer->name();
        $debit1_account_code = new AccountCode(1500);
        $subledger = $customer->account();
        $entry->credit(new Credit($amount, $debit1_account_code, $debit1_description, $subledger));

        // finally save everything
        return $entry->save();

    }


    /* EXPENSE RELATED TRANSACTION */

    /**
     *  Create an expense
     *--------------------------------------------------------------------
     * USER SELECTED EXPENSE ACCOUNT : DEBIT AMOUNT WITHOUT VAT
     * VAT ACCOUNT                   : DEBIT VAT AMOUNT
     * 2400+sub-ledger account       : CREDIT FULL AMOUNT INCLUDING VAT
     * -------------------------------------------------------------------
     * @param Expense $expense
     * @param AccountCode $UserSelectedcode
     * @param $amount
     * @param $vat
     * @internal param AccountCode $code
     * @return array
     */
    public static function createAnExpense(Expense $expense, Supplier $supplier, AccountCode $UserSelectedcode, $amount, $vat)
    {
        $vat = new Vat($vat);
        $amount = new Amount($amount);
        $amount_vat = $amount->vat($vat);
        $amount_without_vat = $amount->withoutVat($vat);

        // initialised entry object
        $entry = new Entry();

        //Create a transaction
        $transaction_description = "Create an expense";
        $entry->transaction(new Transaction($amount, $transaction_description, $vat, self::EXPENSE, $expense->id));

        // Debit Expense Account  - Amount without vat
        $credit1_account_code = new AccountCode($UserSelectedcode);
        $credit1_description = "Expense Account";
        $entry->debit(new Debit($amount_without_vat, $credit1_account_code, $credit1_description));

        // Debit Vat amount
        $credit2_account_code = new AccountCode($vat->accountCode());
        $credit2_description = "Vat Amount";
        $entry->debit(new Debit($amount_vat, $credit2_account_code, $credit2_description));

        // credit a customer
        $debit1_description = $supplier->name();
        $debit1_account_code = new AccountCode(1500);
        $subledger = $supplier->account();
        $entry->credit(new Credit($amount, $debit1_account_code, $debit1_description, $subledger));

        // finally save everything
        return $entry->save();
    }

    /*
     * Expense Paid (full or partial) with Bank
     * --------------------
     * VAT ACCOUNT                   :   DEBIT VAT AMOUNT
     * USER SELECTED EXPENSE ACCOUNT :   DEBIT AMOUNT WITHOUT VAT
     * 2400+sub-ledger account       :   CREDIT FULL AMOUNT INCLUDING VAT
     * ------------------------
     * @param Expense $expense
     * @param Supplier $supplier
     * @param $amount
     */
    public static function expensePaidWithBank(Expense $expense, Supplier $supplier, $userSelectedCode, $amount, $vat)
    {

        $vat = new Vat($vat);
        $amount = new Amount($amount);
        $amount_vat = $amount->vat($vat);
        $amount_without_vat = $amount->withoutVat($vat);

        // initialised entry object
        $entry = new Entry();

        //Create a transaction
        $transaction_description = "Expenses paid with bank account";
        $entry->transaction(new Transaction($amount, $transaction_description, $vat, self::EXPENSE, $expense->id));

        // Debit Vat amount
        $debit1_account_code = new AccountCode($vat->accountCode());
        $debit1_description = "Vat Amount";
        $entry->debit(new Debit($amount_vat, $debit1_account_code, $debit1_description));

        // Debit User selected Expense Account  - Amount without vat
        $debit2_account_code = new AccountCode($userSelectedCode);
        $debit2_description = "User selected Expense Account";
        $entry->debit(new Debit($amount_without_vat, $debit2_account_code, $debit2_description));


        // credit a supplier
        $credit1_description = $supplier->name();
        $credit1_account_code = new AccountCode(2400);
        $subLedger = $supplier->account();
        $entry->credit(new Credit($amount, $credit1_account_code, $credit1_description, $subLedger));

        // finally save everything
        return $entry->save();
    }


    /**
     * Expense Paid with Cash
     *------------------------------------------------------
     * 2711 Incoming VAT High Rate 25%      DEBIT VAT AMOUNT
     * User selected account                DEBIT AMOUNT WITHOUT VAT
     * PAYMENT METHOD (BANK OR CREDIT)      CREDIT FULL AMOUNT INCLUDING VAT
     * ------------------------------------------------------
     * @param Expense $expense
     * @param AccountCode $userSelectedcode
     * @param $amount
     * @param $vat
     * @internal param Supplier $supplier
     * @return array
     */
    public static function expensePaidWithCash(Expense $expense, AccountCode $userSelectedcode, $amount, $vat)
    {
        $vat = new Vat($vat);
        $amount = new Amount($amount);
        $amount_vat = $amount->vat($vat);
        $amount_without_vat = $amount->withoutVat($vat);

        // initialised entry object
        $entry = new Entry();

        //Create a transaction
        $transaction_description = "Cash expenses";
        $entry->transaction(new Transaction($amount, $transaction_description, $vat, self::EXPENSE, $expense->id));

        // Debit Expense Account  - Amount without vat
        $credit1_account_code = new AccountCode($userSelectedcode);
        $credit1_description = "Expense Account";
        $entry->debit(new Credit($amount_without_vat, $credit1_account_code, $credit1_description));

        // Debit Vat amount
        $credit2_account_code = new AccountCode($vat->accountCode());
        $credit2_description = "Vat Amount";
        $entry->debit(new Credit($amount_vat, $credit2_account_code, $credit2_description));


        // Credit Bank Account
        $credit1_account_code = new AccountCode(1920);
        $credit1_description = "Bank Account";
        $entry->credit(new Credit($amount, $credit1_account_code, $credit1_description));

        // finally save everything
        return $entry->save();
    }

    public static function expenseCancel()
    {

    }

    public static function paySalary()
    {

    }


}
