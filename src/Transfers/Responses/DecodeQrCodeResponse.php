<?php

namespace Delfinance\Transfers\Responses;

/**
 * Class DecodeQrCodeResponse
 */
class DecodeQrCodeResponse
{
    /**
     * @var string
     */
    public $key;

    /**
     * @var string
     */
    public $endToEndId;

    /**
     * @var string
     */
    public $transactionId;

    /**
     * @var string
     */
    public $expirationTime;

    /**
     * @var string
     */
    public $revision;

    /**
     * @var bool
     */
    public $allowChangeAmount;

    /**
     * @var bool
     */
    public $categoryCode;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $capturedAt;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $status;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var array|null
     */
    public $originalAmount;

    /**
     * @var string
     */
    public $fineAmount;

    /**
     * @var string
     */
    public $feesAmount;

    /**
     * @var string
     */
    public $discountAmount;

    /**
     * @var string
     */
    public $rebateAmount;

    /**
     * @var string
     */
    public $dueDate;

    /**
     * @var int
     */
    public $paymentDeadline;

    /**
     * @var array|null
     */
    public $payer;

    /**
     * @var array|null
     */
    public $bankAccountRecipient;

    /**
     * @var array|null
     */
    public $beneficiary;

    /**
     * @var array|null
     */
    public $additionalInfos;

    /**
     * @var array|null
     */
    public $recurrence;
}
