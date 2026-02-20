<?php

namespace Delfinance\Charges\Dto;

class Discount
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var DiscountItem[]
     */
    public $items;

    public function __construct($type, array $items = [])
    {
        $this->type = $type;
        $this->items = $items;
    }
}
