<?php

namespace Delfinance\Transfers\Responses;

/**
 * Class PaymentInitializationResponse
 */
class PaymentInitializationResponse
{
    /**
     * @var string
     */
    public $endToEndId;

    /**
     * @var string
     */
    public $key;

    /**
     * @var array|null
     */
    public $beneficiary;

    /**
     * @var bool
     */
    public $keyBelongsHolder;
}
