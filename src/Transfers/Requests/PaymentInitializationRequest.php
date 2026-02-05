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
     * @var string
     */
    public $holderDocument;

    /**
     * PaymentInitializationRequest constructor.
     * @param string $key
     * @param string $holderDocument
     */
    public function __construct($key, $holderDocument)
    {
        $this->key = $key;
        $this->holderDocument = $holderDocument;
    }
}
