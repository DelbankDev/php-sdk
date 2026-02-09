<?php

namespace Delfinance\QrCode\Responses;

use Delfinance\QrCode\Dto\AddressDTO;

/**
 * Class CreateStaticQrCodeResponse
 */
class CreateStaticQrCodeResponse
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
    public $beneficiaryName;

    /**
     * @var string|null
     */
    public $beneficiaryIspb;

    /**
     * @var AddressDTO|array|null
     */
    public $address;

    /**
     * @var string|null
     */
    public $additionalInfo;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $payloadPix;

    /**
     * @var string|null
     */
    public $base64Image;

    /**
     * @var string|null
     */
    public $ispbPss;
}
