<?php

namespace App\Http\Tenant\Accounting\Entity;

class Amount {

    protected $amount;

    function __construct($amount)
    {
        $this->amount = $amount;
    }

    function vat(Vat $vat)
    {
        $amount = $this->amount * $vat->percentage();
        return new static($amount);
    }

    function withoutVat(Vat $vat)
    {
        $amount = $this->amount * (1 - $vat->percentage());

        return new static($amount);

    }

    function format()
    {
        if ($this->amount != null)
            return number_format($this->amount, 2);

        return null;
    }

    function __toString()
    {
        return (string) $this->amount;
    }
}