<?php

namespace Delfinance\QrCode\Requests;

/**
 * Class StaticQrCodeRequest
 */
class StaticQrCodeRequest
{
    /**
     * @var string
     */
    public $correlationId;

    /**
     * @var float|null
     */
    public $amount;

    /**
     * @var string|null
     */
    public $pixKey;

    /**
     * @var string|null
     */
    public $ispbPss;

    /**
     * @var AddressDTO|null
     */
    public $address;

    /**
     * @var string|null
     */
    public $beneficiaryName;

    /**
     * @var string|null
     */
    public $additionalInfo;

    /**
     * @var string
     */
    public $source;

    /**
     * @var string
     */
    public $formatResponse;

    /**
     * StaticQrCodeRequest constructor.
     * @param string $correlationId
     * @param float|null $amount
     * @param string|null $pixKey
     * @param string|null $ispbPss
     * @param AddressDTO|null $address
     * @param string|null $beneficiaryName
     * @param string|null $additionalInfo
     * @param string $source
     * @param string $formatResponse
     */
    public function __construct(
        $correlationId,
        $amount = null,
        $pixKey = null,
        $ispbPss = null,
        $address = null,
        $beneficiaryName = null,
        $additionalInfo = null,
        $source = 'QR_CODE_API',
        $formatResponse = 'ONLY_PAYLOAD'
    ) {
        $this->correlationId = $correlationId;
        $this->amount = $amount;
        $this->pixKey = $pixKey;
        $this->ispbPss = $ispbPss;
        $this->address = $address;
        $this->beneficiaryName = $beneficiaryName;
        $this->additionalInfo = $additionalInfo;
        $this->source = $source;
        $this->formatResponse = $formatResponse;
    }
}
