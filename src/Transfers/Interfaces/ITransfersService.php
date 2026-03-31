<?php

namespace Delfinance\Transfers\Interfaces;

use Delfinance\Transfers\Requests\CreateTransferRequest;
use Delfinance\Transfers\Requests\CreateTedTransferRequest;
use Delfinance\Transfers\Responses\GetTransferResponse;
use Delfinance\Transfers\Responses\CreateTransferResponse;
use Delfinance\Transfers\Responses\CreateTedTransferResponse;

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

    /**
     * Initializes a transfer.
     *
     * @param CreateTransferRequest $request
     * @param string $idempotencyKey
     * @return CreateTransferResponse
     */
    public function createTransfer(CreateTransferRequest $request, $idempotencyKey);

    /**
     * Initializes a TED transfer.
     *
     * @param CreateTedTransferRequest $request
     * @param string $idempotencyKey
     * @return CreateTedTransferResponse
     */
    public function createTedTransfer(CreateTedTransferRequest $request, $idempotencyKey);
}
