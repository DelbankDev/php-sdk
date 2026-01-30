<?php

namespace Delfinance\Transfers\Services;

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\Transfers\Interfaces\ITransfersService;
use Delfinance\Transfers\Responses\GetTransferResponse;
use Delfinance\Transfers\Dto\TransferDto;
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
     * TransfersService constructor.
     * @param DelfinanceClient $client
     */
    public function __construct(DelfinanceClient $client)
    {
        $this->client = $client;
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
        
        // Configuração do cURL
        $ch = curl_init();
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'x-delbank-api-key: ' . $this->client->getApiKey(),
            'x-delfinance-account-id: ' . $this->client->getAccountId(),
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => 'GET',
            // Timeout padrão
            CURLOPT_TIMEOUT => 30,
        ];

        // Configuração mTLS se fornecida
        if ($this->client->getCertificatePath() && $this->client->getPrivateKeyPath()) {
            $options[CURLOPT_SSLCERT] = $this->client->getCertificatePath();
            $options[CURLOPT_SSLKEY] = $this->client->getPrivateKeyPath();
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);

        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }

        if ($httpCode >= 400) {
            throw new Exception("API Error: " . $response, $httpCode);
        }

        $data = json_decode($response, true);

        $dto = new TransferDto();

        $dto->id = isset($data['id']) ? $data['id'] : null;
        $dto->endToEndId = isset($data['endToEndId']) ? $data['endToEndId'] : null;
        $dto->externalId = isset($data['externalId']) ? $data['externalId'] : null;
        $dto->status = isset($data['status']) ? $data['status'] : null;
        $dto->type = isset($data['type']) ? $data['type'] : null;
        $dto->amount = isset($data['amount']) ? $data['amount'] : null;
        $dto->createdAt = isset($data['createdAt']) ? $data['createdAt'] : null;
        $dto->updatedAt = isset($data['updatedAt']) ? $data['updatedAt'] : null;
        
        // TODO: DTOs para Error, Payer e Beneficiary.
        $dto->error = isset($data['error']) ? $data['error'] : null;
        $dto->payer = isset($data['payer']) ? $data['payer'] : null;
        $dto->beneficiary = isset($data['beneficiary']) ? $data['beneficiary'] : null;

        return new GetTransferResponse($dto);
    }
}
