<?php

namespace Delfinance\Transfers\Responses;

use Delfinance\Transfers\Dto\TransferDto;

/**
 * Class GetTransferResponse
 */
class GetTransferResponse
{
    /**
     * @var TransferDto
     */
    public $transfer;

    /**
     * GetTransferResponse constructor.
     * @param TransferDto $transfer
     */
    public function __construct(TransferDto $transfer)
    {
        $this->transfer = $transfer;
    }
}
