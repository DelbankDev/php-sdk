<?php

namespace Delfinance\QrCode\Responses;

/**
 * Class CreateImmediateQrCodeResponse
 */
class CreateImmediateQrCodeResponse
{
    /**
     * @var string|null
     */
    public $payloadJws;

    /**
     * @var string|null
     */
    public $correlationId;

    /**
     * @var string|null
     */
    public $transactionId;

    /**
     * @var float|null
     */
    public $amount;

    /**
     * @var bool|null
     */
    public $allowChangeAmount;

    /**
     * @var int|null
     */
    public $expiresIn;

    /**
     * @var string|null
     */
    public $status;

    /**
     * @var array|object|null
     */
    public $payer;

    /**
     * @var array|object|null
     */
    public $address;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $updatedAt;

    /**
     * @var string|null
     */
    public $expiresAt;

    /**
     * @var string|null
     */
    public $payloadPix;

    /**
     * @var string|null
     */
    public $qrCodeImageBase64;

    /**
     * @var array|null
     */
    public $additionalInfos;

    /**
     * @var array|null
     */
    public $splitInstructions;
}
