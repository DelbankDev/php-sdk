<?php

namespace Delfinance\Charges\Dto;

/**
 * Class Address
 */
class Address
{
    /**
     * @var string
     */
    public $zipCode;

    /**
     * @var string
     */
    public $publicPlace;

    /**
     * @var string
     */
    public $neighborhood;

    /**
     * @var string
     */
    public $number;

    /**
     * @var string
     */
    public $complement;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $state;

    /**
     * Address constructor.
     * @param string $zipCode
     * @param string $publicPlace
     * @param string $neighborhood
     * @param string $number
     * @param string $complement
     * @param string $city
     * @param string $state
     */
    public function __construct(
        $zipCode,
        $publicPlace,
        $neighborhood,
        $number,
        $complement,
        $city,
        $state
    ) {
        $this->zipCode = $zipCode;
        $this->publicPlace = $publicPlace;
        $this->neighborhood = $neighborhood;
        $this->number = $number;
        $this->complement = $complement;
        $this->city = $city;
        $this->state = $state;
    }
}
