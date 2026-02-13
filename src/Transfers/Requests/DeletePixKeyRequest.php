<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class DeletePixKeyRequest
 */
class DeletePixKeyRequest
{
    /**
     * @var string
     * Required. Possible values: DOCUMENT, EMAIL, PHONE, EVP
     */
    public $entryType;

    /**
     * @var string
     * Required. The key to be deleted.
     */
    public $key;

    /**
     * DeletePixKeyRequest constructor.
     * @param string $entryType
     * @param string $key
     */
    public function __construct($entryType, $key)
    {
        $this->entryType = $entryType;
        $this->key = $key;
    }
}
