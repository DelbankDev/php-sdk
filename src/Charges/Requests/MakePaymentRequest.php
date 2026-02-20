<?php

namespace Delfinance\Charges\Requests;

class MakePaymentRequest
{
    /** @var float */
    public $amount;
    
    /** @var string|null */
    public $barCode;
    
    /** @var string|null */
    public $digitableLine;
}
