<?php

namespace Delfinance\Transfers\Services;

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\Transfers\Interfaces\ITransfersService;
use Delfinance\Transfers\Requests\CreateTransferRequest;
use Delfinance\Transfers\Requests\CreateTedTransferRequest;
use Delfinance\Transfers\Responses\GetTransferResponse;
use Delfinance\Transfers\Responses\CreateTransferResponse;
use Delfinance\Transfers\Responses\CreateTedTransferResponse;
use Delfinance\Utils\RequestHelper;
use Exception;

/**
 * Class TransfersService
 */
class TransfersService implements ITransfersService
{
    /**
     * @var DelfinanceClient
     */
    private $client;

    /**
     * @var RequestHelper
     */
    private $requestHelper;

    /**
     * TransfersService constructor.
     * @param DelfinanceClient $client
     */
    public function __construct(DelfinanceClient $client)
    {
        $this->client = $client;
        $this->requestHelper = new RequestHelper($client);
    }

    /**
     * Get a transfer by its identifier.
     *
     * @param string $transferIdentifier
     * @return GetTransferResponse
     * @throws Exception
     */
    public function getTransfer($transferIdentifier)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/transfers/' . $transferIdentifier;
        
        $response = $this->requestHelper->execute('GET', $url);
        $data = json_decode($response, true);

        $responseObj = new GetTransferResponse();

        $responseObj->id = isset($data['id']) ? $data['id'] : null;
        $responseObj->endToEndId = isset($data['endToEndId']) ? $data['endToEndId'] : null;
        $responseObj->externalId = isset($data['externalId']) ? $data['externalId'] : null;
        $responseObj->status = isset($data['status']) ? $data['status'] : null;
        $responseObj->type = isset($data['type']) ? $data['type'] : null;
        $responseObj->amount = isset($data['amount']) ? $data['amount'] : null;
        $responseObj->createdAt = isset($data['createdAt']) ? $data['createdAt'] : null;
        $responseObj->updatedAt = isset($data['updatedAt']) ? $data['updatedAt'] : null;
        
        // TODO: DTOs para Error, Payer e Beneficiary.
        $responseObj->error = isset($data['error']) ? $data['error'] : null;
        $responseObj->payer = isset($data['payer']) ? $data['payer'] : null;
        $responseObj->beneficiary = isset($data['beneficiary']) ? $data['beneficiary'] : null;

        return $responseObj;
    }

    public function getTedTransfer($transferIdentifier)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/transfers/ted/' . $transferIdentifier;
        
        $response = $this->requestHelper->execute('GET', $url);
        $data = json_decode($response, true);

        $responseObj = new GetTransferResponse();

        $responseObj->id = isset($data['id']) ? $data['id'] : null;
        $responseObj->endToEndId = isset($data['endToEndId']) ? $data['endToEndId'] : null;
        $responseObj->externalId = isset($data['externalId']) ? $data['externalId'] : null;
        $responseObj->status = isset($data['status']) ? $data['status'] : null;
        $responseObj->type = isset($data['type']) ? $data['type'] : null;
        $responseObj->amount = isset($data['amount']) ? $data['amount'] : null;
        $responseObj->createdAt = isset($data['createdAt']) ? $data['createdAt'] : null;
        $responseObj->updatedAt = isset($data['updatedAt']) ? $data['updatedAt'] : null;

        $responseObj->error = isset($data['error']) ? $data['error'] : null;
        $responseObj->payer = isset($data['payer']) ? $data['payer'] : null;
        $responseObj->beneficiary = isset($data['beneficiary']) ? $data['beneficiary'] : null;

        return $responseObj;
    }

    /**
     * Initializes a transfer.
     *
     * @param CreateTransferRequest $request
     * @param string $idempotencyKey
     * @return CreateTransferResponse
     * @throws Exception
     */
    public function createTransfer(CreateTransferRequest $request, $idempotencyKey)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/transfers';
        
        $payload = [
            'amount' => $request->amount,
            'description' => $request->description,
            'endToEndId' => $request->endToEndId,
            'initiationType' => $request->initiationType,
            'beneficiaryId' => $request->beneficiaryId,
            'saveFavorite' => $request->saveFavorite,
            'type' => $request->type,
            'beneficiary' => $request->beneficiary,
            'beneficiaryAccount' => $request->beneficiaryAccount,
            'transactionId' => $request->transactionId,
            'transferAt' => $request->transferAt,
            'tags' => $request->tags,
            'externalId' => $request->externalId,
            'splitInstructions' => $request->splitInstructions
        ];

        // Remove null values to avoid sending unnecessary data
        $payload = array_filter($payload, function($value) {
            return $value !== null;
        });

        $body = json_encode($payload);

        $response = $this->requestHelper->execute('POST', $url, $body, ['IdempotencyKey: ' . $idempotencyKey]);
        $data = json_decode($response, true);
        
        $responseObj = new CreateTransferResponse();
        
        $responseObj->id = isset($data['id']) ? $data['id'] : null;
        $responseObj->endToEndId = isset($data['endToEndId']) ? $data['endToEndId'] : null;
        $responseObj->transactionNsu = isset($data['transactionNsu']) ? $data['transactionNsu'] : null;
        $responseObj->externalId = isset($data['externalId']) ? $data['externalId'] : null;
        $responseObj->status = isset($data['status']) ? $data['status'] : null;
        $responseObj->type = isset($data['type']) ? $data['type'] : null;
        $responseObj->amount = isset($data['amount']) ? $data['amount'] : null;
        $responseObj->createdAt = isset($data['createdAt']) ? $data['createdAt'] : null;
        $responseObj->description = isset($data['description']) ? $data['description'] : null;
        $responseObj->updatedAt = isset($data['updatedAt']) ? $data['updatedAt'] : null;
        
        $responseObj->error = isset($data['error']) ? $data['error'] : null;
        $responseObj->payer = isset($data['payer']) ? $data['payer'] : null;
        $responseObj->beneficiary = isset($data['beneficiary']) ? $data['beneficiary'] : null;

        return $responseObj;
    }

    /**
     * Initializes a TED transfer.
     *
     * @param CreateTedTransferRequest $request
     * @param string $idempotencyKey
     * @return CreateTedTransferResponse
     * @throws Exception
     */
    public function createTedTransfer(CreateTedTransferRequest $request, $idempotencyKey)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/transfers/ted';
        
        $body = json_encode([
            'amount' => $request->amount,
            'description' => $request->description,
            'beneficiary' => $request->beneficiary
        ]);

        $response = $this->requestHelper->execute('POST', $url, $body, ['IdempotencyKey: ' . $idempotencyKey]);
        $data = json_decode($response, true);
        
        $responseObj = new CreateTedTransferResponse();
        
        $responseObj->id = isset($data['id']) ? $data['id'] : null;
        $responseObj->status = isset($data['status']) ? $data['status'] : null;
        $responseObj->paymentChannel = isset($data['paymentChannel']) ? $data['paymentChannel'] : null;
        $responseObj->type = isset($data['type']) ? $data['type'] : null;
        $responseObj->amount = isset($data['amount']) ? $data['amount'] : null;
        $responseObj->createdAt = isset($data['createdAt']) ? $data['createdAt'] : null;
        $responseObj->updatedAt = isset($data['updatedAt']) ? $data['updatedAt'] : null;
        $responseObj->description = isset($data['description']) ? $data['description'] : null;
        $responseObj->payer = isset($data['payer']) ? $data['payer'] : null;
        $responseObj->beneficiary = isset($data['beneficiary']) ? $data['beneficiary'] : null;

        return $responseObj;
    }
}
