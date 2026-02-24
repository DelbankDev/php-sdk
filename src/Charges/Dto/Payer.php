<?php

namespace Delfinance\Charges\Dto;

/**
 * Class Payer
 */
class Payer
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $document;

    /**
     * @var string
     */
    public $email;

    /**
     * @var Phone
     */
    public $phone;

    /**
     * @var Address
     */
    public $address;

    /**
     * Payer constructor.
     * @param string $name
     * @param string $document
     * @param string $email
     * @param Phone $phone
     * @param Address $address
     */
    public function __construct($name, $document, $email, Phone $phone, Address $address)
    {
        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
    }
}
