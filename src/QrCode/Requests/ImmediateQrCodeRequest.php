<?php

namespace Delfinance\QrCode\Requests;

/**
 * Class ImmediateQrCodeRequest
 */
class ImmediateQrCodeRequest
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
     * @var array|object|null
     */
    public $address;

    /**
     * @var array|object|null
     */
    public $payer;

    /**
     * @var array|object|null
     */
    public $finalBeneficiary;

    /**
     * @var string
     */
    public $formatResponse;

    /**
     * @var array|null
     */
    public $additionalInfos;

    /**
     * @var string|int
     */
    public $expiresIn;

    /**
     * @var bool|null
     */
    public $allowChangeAmount;

    /**
     * @var array|object|null
     */
    public $change;

    /**
     * @var array|object|null
     */
    public $withdrawal;

    /**
     * @var array|null
     */
    public $splitInstructions;

    /**
     * @var array|null
     */
    public $allowedPayersAccount;

    /**
     * ImmediateQrCodeRequest constructor.
     * @param string $correlationId
     * @param float $amount
     * @param string|null $pixKey
     * @param array|object|null $address
     * @param array|object|null $payer
     * @param array|object|null $finalBeneficiary
     * @param string $formatResponse
     * @param array|null $additionalInfos
     * @param string|int $expiresIn
     * @param bool|null $allowChangeAmount
     * @param array|object|null $change
     * @param array|object|null $withdrawal
     * @param array|null $splitInstructions
     * @param array|null $allowedPayersAccount
     */
    public function __construct(
        $correlationId,
        $amount,
        $pixKey = null,
        $address = null,
        $payer = null,
        $finalBeneficiary = null,
        $formatResponse = 'ONLY_PAYLOAD',
        $additionalInfos = null,
        $expiresIn = '86400',
        $allowChangeAmount = null,
        $change = null,
        $withdrawal = null,
        $splitInstructions = null,
        $allowedPayersAccount = null
    ) {
        $this->correlationId = $correlationId;
        $this->amount = $amount;
        $this->pixKey = $pixKey;
        $this->address = $address;
        $this->payer = $payer;
        $this->finalBeneficiary = $finalBeneficiary;
        $this->formatResponse = $formatResponse;
        $this->additionalInfos = $additionalInfos;
        $this->expiresIn = $expiresIn;
        $this->allowChangeAmount = $allowChangeAmount;
        $this->change = $change;
        $this->withdrawal = $withdrawal;
        $this->splitInstructions = $splitInstructions;
        $this->allowedPayersAccount = $allowedPayersAccount;
    }
}
