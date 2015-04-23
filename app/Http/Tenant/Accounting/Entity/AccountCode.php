<?php
namespace App\Http\Tenant\Accounting\Entity;

class AccountCode {

    protected $code = null;
    protected $accounts = [];

    function __construct($code)
    {
        $this->accounts = \Config::get('accounts.codes');

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
        if (array_key_exists($code, self::$accounts)) {
            return true;
        }

        return false;
    }

    function description()
    {
        return $this->accounts[$this->code]['en'];
    }


    /**
     * @return null
     */
    public function __toString()
    {
        return (string)$this->code;
    }

} 