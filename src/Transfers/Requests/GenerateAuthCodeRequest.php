<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class GenerateAuthCodeRequest
 * Request payload for generating an authentication code for Pix keys (EMAIL or PHONE).
 */
class GenerateAuthCodeRequest
{
    /**
     * @var string
     * Required. "EMAIL" or "SMS".
     */
    public $sender;

    /**
     * @var string
     * Required. The email address or phone number (with country code, e.g., +55...).
     */
    public $receiver;

    /**
     * @var string
     * Required. Message template. Must contain the placeholder {{code}}.
     * Example: "Your authentication code is: {{code}}"
     */
    public $payload;

    /**
     * GenerateAuthCodeRequest constructor.
     * @param string $sender
     * @param string $receiver
     * @param string $payload
     */
    public function __construct($sender, $receiver, $payload)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->payload = $payload;
    }
}
