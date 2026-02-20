<?php

namespace Delfinance\Charges\Dto;

class Beneficiary
{
    /**
     * @var string
     */
    public $branch;

    /**
     * @var string
     */
    public $bankAccount;

    /**
     * @var string
     */
    public $document;

    /**
     * @var string
     */
    public $name;

    /**
     * @var Address
     */
    public $address;

    public function __construct($branch, $bankAccount, $document, $name, Address $address)
    {
        $this->branch = $branch;
        $this->bankAccount = $bankAccount;
        $this->document = $document;
        $this->name = $name;
        $this->address = $address;
    }
}
