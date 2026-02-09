<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class DecodeQrCodeRequest
 * Request payload for initializing a Pix payment via QR Code.
 */
class DecodeQrCodeRequest
{
    /**
     * @var string
     */
    public $payload;

    /**
     * DecodeQrCodeRequest constructor.
     * @param string $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }
}
