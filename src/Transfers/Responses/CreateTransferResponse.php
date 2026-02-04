<?php

namespace Delfinance\Transfers\Responses;

/**
 * Class CreateTransferResponse
 */
class CreateTransferResponse
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $endToEndId;

    /**
     * @var int|string
     */
    public $transactionNsu;

    /**
     * @var string
     */
    public $externalId;

    /**
     * @var string
     */
    public $status;

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
    public $description;

    /**
     * @var string
     */
    public $updatedAt;

    /**
     * @var array|null
     */
    public $error;

    /**
     * @var array|null
     */
    public $payer;

    /**
     * @var array|null
     */
    public $beneficiary;
}
