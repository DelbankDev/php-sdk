<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class PaymentInitializationRequest
 * Request payload for initializing a Pix payment.
 */
class PaymentInitializationRequest
{
    /**
     * @var string
     */
    public $key;

    /**
     * PaymentInitializationRequest constructor.
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }
}
