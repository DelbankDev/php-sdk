<?php

namespace Delfinance\Charges\Dto;

class LateFine
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $date;

    /**
     * @var float
     */
    public $amount;

    public function __construct($type, $date, $amount)
    {
        $this->type = $type;
        $this->date = $date;
        $this->amount = $amount;
    }
}
