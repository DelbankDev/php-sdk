<?php

namespace Delfinance\Transfers\Dto;

/**
 * Class TransferDto
 * Represents the data of a transfer.
 */
class TransferDto
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
