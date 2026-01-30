<?php

namespace Delfinance\Transfers\Interfaces;

use Delfinance\Transfers\Responses\GetTransferResponse;

/**
 * Interface ITransfersService
 */
interface ITransfersService
{
    /**
     * Get a transfer by its identifier.
     *
     * @param string $transferIdentifier
     * @return GetTransferResponse
     */
    public function getTransfer($transferIdentifier);
}
