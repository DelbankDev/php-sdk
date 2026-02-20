<?php

namespace Delfinance\Charges\Dto;

/**
 * Class Phone
 */
class Phone
{
    /**
     * @var string
     */
    public $prefix;

    /**
     * @var string
     */
    public $number;

    /**
     * Phone constructor.
     * @param string $prefix
     * @param string $number
     */
    public function __construct($prefix, $number)
    {
        $this->prefix = $prefix;
        $this->number = $number;
    }
}
