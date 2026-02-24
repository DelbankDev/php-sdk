<?php

namespace Delfinance\Charges\Dto;

class DiscountItem
{
    /**
     * @var string
     */
    public $date;

    /**
     * @var float
     */
    public $amount;

    public function __construct($date, $amount)
    {
        $this->date = $date;
        $this->amount = $amount;
    }
}
