<?php

namespace Delfinance\QrCode\Responses;

/**
 * Class QrCodeDTO
 */
class GetQrCodeResponse
{
    /**
     * @var string|null
     */
    public $transactionId;

    /**
     * @var string|null
     */
    public $correlationId;

    /**
     * @var string|null
     */
    public $type;

    /**
     * @var float|null
     */
    public $amount;

    /**
     * @var float|null
     */
    public $originalAmount;

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
    public $payloadPix;

    /**
     * @var string|null
     */
    public $expiresAt;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var array|object|null
     */
    public $withdrawal;

    /**
     * @var array|object|null
     */
    public $change;

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
    public $rebate;

    /**
     * @var array|object|null
     */
    public $discount;

    /**
     * @var array|object|null
     */
    public $interest;

    /**
     * @var array|object|null
     */
    public $fine;

    /**
     * @var array|null
     */
    public $payments;

    /**
     * @var string|null
     */
    public $staticAdditionalInfo;

    /**
     * @var array|null
     */
    public $additionalInfo;

    /**
     * @var array|object|null
     */
    public $finalBeneficiary;

    /**
     * @var bool|null
     */
    public $allowChangeAmount;

    /**
     * @var array|null
     */
    public $splitInstructions;

    /**
     * @var array|null
     */
    public $allowedPayersAccount;
}
