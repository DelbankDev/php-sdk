<?php

namespace Delfinance\QrCode\Responses;

/**
 * Class CreateDueDateQrCodeResponse
 */
class CreateDueDateQrCodeResponse
{
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
     * @var float|null
     */
    public $originalAmount;

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
    public $dueDate;

    /**
     * @var int|null
     */
    public $maxDaysOverdue;

    /**
     * @var array|object|null
     */
    public $taxes;

    /**
     * @var string|null
     */
    public $status;

    /**
     * @var int|null
     */
    public $revision;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var array|object|null
     */
    public $payer;

    /**
     * @var array|object|null
     */
    public $address;

    /**
     * @var array|object|null
     */
    public $change;

    /**
     * @var array|object|null
     */
    public $withdrawal;

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
    public $payments;

    /**
     * @var array|null
     */
    public $additionalInfos;

    /**
     * @var array|object|null
     */
    public $payloadLocation;

    /**
     * @var array|object|null
     */
    public $finalBeneficiary;

    /**
     * @var array|null
     */
    public $splitInstructions;
}
