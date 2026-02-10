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
     * @var string|null
     */
    public $holderDocument;

    /**
     * PaymentInitializationRequest constructor.
     * @param string $key
     * @param string|null $holderDocument
     */
    public function __construct($key, $holderDocument = null)
    {
        $this->key = $key;
        $this->holderDocument = $holderDocument;
    }
}
