<?php

namespace Delfinance\Transfers\Responses;

/**
 * Class CreateBatchTransferResponse
 */
class CreateBatchTransferResponse
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $bankAccountNumber;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $createdBy;

    /**
     * @var array
     */
    public $items;
}
