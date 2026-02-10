<?php

namespace Delfinance\QrCode\Dto;

class AddressDTO
{
    /**
     * @var string
     */
    public $cityName;

    /**
     * @var string
     */
    public $zipCode;

    /**
     * @var string
     */
    public $uf;

    /**
     * @var string
     */
    public $state;

    /**
     * @var string
     */
    public $street;

    /**
     * AddressDTO constructor.
     * @param string $cityName
     * @param string $zipCode
     * @param string $uf
     * @param string $state
     * @param string $street
     */
    public function __construct($cityName, $zipCode, $uf, $state, $street)
    {
        $this->cityName = $cityName;
        $this->zipCode = $zipCode;
        $this->uf = $uf;
        $this->state = $state;
        $this->street = $street;
    }
}
