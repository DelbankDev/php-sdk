<?php

namespace Delfinance\Transfers\Responses;

/**
 * Class CreateTedTransferResponse
 */
class CreateTedTransferResponse
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $paymentChannel;

    /**
     * @var string
     */
    public $type;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $updatedAt;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array|null
     */
    public $payer;

    /**
     * @var array|null
     */
    public $beneficiary;
}
