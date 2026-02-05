<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class CreateBatchTransferRequest
 */
class CreateBatchTransferRequest
{
    /**
     * @var BatchTransferItem[]
     */
    public $items;

    /**
     * CreateBatchTransferRequest constructor.
     * @param BatchTransferItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }
}
