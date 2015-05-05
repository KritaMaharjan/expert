<?php
namespace App\Http\Tenant\Accounting\Entity;

class Vat {

    protected $code = null;

    function __construct($code)
    {
        if (self::isValidVatPercentage($code)) {
            $this->code = $code;
        } else {
            throw new \Exception('Invalid Vat Percentage');
        }
    }

    /**
     * Check for valid account number
     */
    public static function isValidVatPercentage($code)
    {
        if($code =='') return false;

        $code = number_format($code,0);

        $accounts = self::code();
        if (array_key_exists($code, $accounts)) {
            return true;
        }

        return false;
    }


    public static function code()
    {
        $codes = \Config::get('accounts.vat');
        return $codes;
    }

    /**
     * @return float
     */
    public function percentage()
    {
        return $this->code / 100;
    }


    public function accountCode()
    {
        $code = self::code();

        return isset($code[$this->code]['account_code']) ? $code[$this->code]['account_code'] : null;
    }

    public static function isAccountCode($account)
    {
        $codes = self::code();

        foreach ($codes as $key => $code) {
            if ($code['account_code'] == $account) {
                return $code;
            }
        }

        return null;
    }


    /**
     * @return null
     */
    public function __toString()
    {
        return (string)$this->code;
    }

}