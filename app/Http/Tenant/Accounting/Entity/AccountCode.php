<?php
namespace App\Http\Tenant\Accounting\Entity;

class AccountCode {

    protected $code = null;

    function __construct($code)
    {
        if (self::isValidCode($code)) {
            $this->code = $code;
        } else {
            throw new \Exception('Invalid Account Code');
        }
    }

    /**
     * Check for valid account number
     */
    public static function isValidCode($code)
    {
        $accounts = \Config::get('accounts.codes');
        if (array_key_exists($code, $accounts)) {
            return true;
        }

        return false;
    }


    /**
     * @return null
     */
    public function __toString()
    {
        return (string) $this->code;
    }

} 