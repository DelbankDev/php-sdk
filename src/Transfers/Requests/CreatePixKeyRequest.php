<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class CreatePixKeyRequest
 */
class CreatePixKeyRequest
{
    /**
     * @var string
     * Required. Possible values: DOCUMENT, EMAIL, PHONE, EVP
     */
    public $entryType;

    /**
     * @var string|null
     * Required if entryType is DOCUMENT, EMAIL, or PHONE.
     */
    public $key;

    /**
     * @var string|null
     * Required for PHONE and EMAIL types.
     */
    public $authCode;

    /**
     * @var string|null
     * Required for PHONE and EMAIL types.
     */
    public $authId;

    /**
     * CreatePixKeyRequest constructor.
     * @param string $entryType
     * @param string|null $key
     * @param string|null $authCode
     * @param string|null $authId
     */
    public function __construct($entryType, $key = null, $authCode = null, $authId = null)
    {
        $this->entryType = $entryType;
        $this->key = $key;
        $this->authCode = $authCode;
        $this->authId = $authId;
    }
}
