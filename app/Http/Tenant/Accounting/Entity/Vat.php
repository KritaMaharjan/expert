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
        $accounts = self::code();
        if (array_key_exists($code, $accounts)) {
            return true;
        }

        return false;
    }


    public static function code()
    {
        return \Config::get('accounts.vat');
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

        return isset($code[$this->code]) ? $code[$this->code] : null;
    }


    /**
     * @return null
     */
    public function __toString()
    {
        return (string)$this->code;
    }

}