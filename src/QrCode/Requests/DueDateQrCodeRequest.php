<?php

namespace Delfinance\QrCode\Requests;

/**
 * Class DueDateQrCodeRequest
 */
class DueDateQrCodeRequest
{
    /**
     * @var string
     */
    public $correlationId;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string|null
     */
    public $pixKey;

    /**
     * @var array|object
     */
    public $payer;

    /**
     * @var array|object
     */
    public $address;

    /**
     * @var string
     */
    public $formatResponse;

    /**
     * @var array|null
     */
    public $additionalInfos;

    /**
     * @var string
     */
    public $dueDate;

    /**
     * @var int
     */
    public $revision;

    /**
     * @var bool
     */
    public $reusable;

    /**
     * @var int|null
     */
    public $maxDaysOverdue;

    /**
     * @var array|object|null
     */
    public $taxes;

    /**
     * DueDateQrCodeRequest constructor.
     * @param string $correlationId
     * @param float $amount
     * @param string|null $pixKey
     * @param array|object $payer
     * @param array|object $address
     * @param string $dueDate
     * @param string $formatResponse
     * @param array|null $additionalInfos
     * @param int $revision
     * @param bool $reusable
     * @param int $maxDaysOverdue
     * @param array|object|null $taxes
     */
    public function __construct(
        $correlationId,
        $amount,
        $pixKey,
        $payer,
        $address,
        $dueDate,
        $formatResponse = 'ONLY_PAYLOAD',
        $additionalInfos = null,
        $revision = 0,
        $reusable = false,
        $maxDaysOverdue = 60,
        $taxes = null
    ) {
        $this->correlationId = $correlationId;
        $this->amount = $amount;
        $this->pixKey = $pixKey;
        $this->payer = $payer;
        $this->address = $address;
        $this->dueDate = $dueDate;
        $this->formatResponse = $formatResponse;
        $this->additionalInfos = $additionalInfos;
        $this->revision = $revision;
        $this->reusable = $reusable;
        $this->maxDaysOverdue = $maxDaysOverdue;
        $this->taxes = $taxes;
    }
}
