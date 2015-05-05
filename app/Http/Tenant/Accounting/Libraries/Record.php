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
     * Debit: 1500+subLedger full amount including VAT
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
        $subLedger = $customer->account();
        $entry->credit(new Credit($amount, $credit2_account_code, $credit2_description, $subLedger));

        // finally save everything
        return $entry->save();

    }


    /**
     *
     * Bill paid including Fee and interest
     * ------------------------------------------------------
     * 1920 Bank Account            DEBIT - Total Amount Paid
     * 1500 kundefordringer         CREDIT - The original bill amount
     * 8055 Fees paid               CREDIT - only total fee and interest amount paid
     * --------------------------------------------------------
     * @param Bill $bill
     * @param Customer $customer
     * @param $billAmount
     * @param $feeAndInterest
     * @internal param $BillAmount
     * @internal param $amount
     * @return array
     */
    function billPaidWithFee(Bill $bill, Customer $customer, $billAmount, $feeAndInterest)
    {
        $billAmount = new Amount($billAmount);
        $feeAndInterest = new Amount($feeAndInterest);
        $totalAmount = new Amount($billAmount + $feeAndInterest);

        // initialised entry object
        $entry = new Entry();

        //Create a transaction
        $transaction_description = "Bill is paid including fee and interest";
        $entry->transaction(new Transaction($totalAmount, $transaction_description, null, self::BILL, $bill->id));

        // Debit Bank account
        $debit1_description = 'Bank Account';
        $debit1_account_code = new AccountCode(1920);
        $entry->debit(new Debit($totalAmount, $debit1_account_code, $debit1_description));

        // Credit Customer account
        $credit1_account_code = new AccountCode(1500);
        $credit1_description = $customer->name();
        $subLedger = $customer->account();
        $entry->credit(new Credit($billAmount, $credit1_account_code, $credit1_description, $subLedger));

        // Credit Fee and interest Account
        $credit2_account_code = new AccountCode(8055);
        $credit2_description = 'Fees paid';
        $entry->credit(new Credit($billAmount, $credit2_account_code, $credit2_description));

        // finally save everything
        return $entry->save();

    }


    /**
     * Credit A Bill
     * --------------------------
     * Debit 2701 Tax amount
     * Debit 3000 Without tax
     * Credit 1500 + subledger customer account
     * --------------------------
     * @param Bill $bill
     * @param Customer $customer
     * @param Amount $amount
     * @param $vat
     * @return array
     */
    public static function billCredit(Bill $bill, Customer $customer, $amount, $vat)
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
     *  Create an expense (When user select Supplier)
     *--------------------------------------------------------------------
     * USER SELECTED EXPENSE ACCOUNT : DEBIT AMOUNT WITHOUT VAT
     * VAT ACCOUNT                   : DEBIT VAT AMOUNT
     * 2400+sub-ledger account       : CREDIT FULL AMOUNT INCLUDING VAT
     * -------------------------------------------------------------------
     * @param Expense $expense
     * @param Supplier $supplier
     * @param $UserSelectedCode
     * @param $amount
     * @param $vat
     * @internal param AccountCode $code
     * @return array
     */
    public static function createAnExpenseWithSupplier(Expense $expense, Supplier $supplier, array $UserSelectedCode, $amount, $vat)
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

        // Debit User selected Expense Account  - Amount without vat
        $credit1_account_code = new AccountCode($UserSelectedCode);
        $credit1_description = "User selected expense account";
        $entry->debit(new Debit($amount_without_vat, $credit1_account_code, $credit1_description));

        // Debit Vat amount
        $credit2_account_code = new AccountCode($vat->accountCode());
        $credit2_description = "Vat Amount";
        $entry->debit(new Debit($amount_vat, $credit2_account_code, $credit2_description));

        // credit a Supplier
        $debit1_description = $supplier->name();
        $debit1_account_code = new AccountCode(1500);
        $subLedger = $supplier->account();
        $entry->credit(new Credit($amount, $debit1_account_code, $debit1_description, $subLedger));

        // finally save everything
        return $entry->save();
    }

    /*
     * Expense Paid (full or partial) to supplier (When user select supplier)
     * --------------------
     * 2400+sub-ledger account       :   DEBIT PAID AMOUNT
     * BANK ACCOUNT                  :   CREDIT PAID AMOUNT
     * ------------------------
     * @param Expense $expense
     * @param Supplier $supplier
     * @param $amount
     */
    public static function expensePaidToSupplier(Expense $expense, Supplier $supplier, $amount)
    {

        $amount = new Amount($amount);

        // initialised entry object
        $entry = new Entry();

        //Create a transaction
        $transaction_description = "Expenses paid";
        $entry->transaction(new Transaction($amount, $transaction_description, null, self::EXPENSE, $expense->id));


        // Debit Amount to supplier's Ledger
        $debit_description = $supplier->name();
        $debit_account_code = new AccountCode(2400);
        $subLedger = $supplier->account();
        $entry->debit(new Debit($amount, $debit_account_code, $debit_description, $subLedger));

        // Credit Bank Account
        $credit_account_code = new AccountCode(1920);
        $credit_description = "Bank Account";
        $entry->credit(new Credit($amount, $credit_account_code, $credit_description));


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
     * @param $userSelectedCode
     * @param $amount
     * @param $vat
     * @internal param AccountCode $userSelectedcode
     * @internal param Supplier $supplier
     * @return array
     */
    public static function expensePaidWithCash(Expense $expense, $userSelectedCode, $amount, $vat)
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

        // Debit User selected Expense Account  - Amount without vat
        $debit1_account_code = new AccountCode($userSelectedCode);
        $debit1_description = "Expense Account";
        $entry->debit(new Debit($amount_without_vat, $debit1_account_code, $debit1_description));

        // Debit Vat amount
        $debit2_account_code = new AccountCode($vat->accountCode());
        $debit2_description = "Vat Amount";
        $entry->debit(new Debit($amount_vat, $debit2_account_code, $debit2_description));


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
