<?php

namespace Delfinance\Transfers\Services;

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\Transfers\Interfaces\IPixService;
use Delfinance\Transfers\Requests\PaymentInitializationRequest;
use Delfinance\Transfers\Requests\DecodeQrCodeRequest;
use Delfinance\Transfers\Requests\CreatePixKeyRequest;
use Delfinance\Transfers\Requests\DeletePixKeyRequest;
use Delfinance\Transfers\Responses\PaymentInitializationResponse;
use Delfinance\Transfers\Responses\DecodeQrCodeResponse;
use Delfinance\Transfers\Responses\CreatePixKeyResponse;
use Delfinance\Transfers\Responses\DeletePixKeyResponse;
use Delfinance\Transfers\Responses\GetPixKeysResponse;
use Delfinance\Utils\RequestHelper;
use Exception;

/**
 * Class PixService
 */
class PixService implements IPixService
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
     * PixService constructor.
     * @param DelfinanceClient $client
     */
    public function __construct(DelfinanceClient $client)
    {
        $this->client = $client;
        $this->requestHelper = new RequestHelper($client);
    }

    /**
     * Initializes a Pix payment using a DICT key.
     *
     * @param PaymentInitializationRequest $request
     * @return PaymentInitializationResponse
     * @throws Exception
     */
    public function paymentInitialization(PaymentInitializationRequest $request)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/dict/payment-initialization';
        
        $payload = [
            'key' => $request->key
        ];

        if (!empty($request->holderDocument)) {
            $payload['holderDocument'] = $request->holderDocument;
        }

        $body = json_encode($payload);

        $response = $this->requestHelper->execute('POST', $url, $body);
        $data = json_decode($response, true);
        
        $responseObj = new PaymentInitializationResponse();
        
        $responseObj->endToEndId = isset($data['endToEndId']) ? $data['endToEndId'] : null;
        $responseObj->key = isset($data['key']) ? $data['key'] : null;
        $responseObj->beneficiary = isset($data['beneficiary']) ? $data['beneficiary'] : null;
        $responseObj->keyBelongsHolder = isset($data['keyBelongsHolder']) ? $data['keyBelongsHolder'] : null;

        return $responseObj;
    }

    /**
     * Initializes a Pix payment using a QR Code payload (decoding the QrCode).
     *
     * @param DecodeQrCodeRequest $request
     * @return DecodeQrCodeResponse
     * @throws Exception
     */
    public function decodeQrCode(DecodeQrCodeRequest $request)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/payment-initialization';
        
        $body = json_encode([
            'payload' => $request->payload
        ]);

        $response = $this->requestHelper->execute('POST', $url, $body);
        $data = json_decode($response, true);
        
        $responseObj = new DecodeQrCodeResponse();
        
        foreach ($data as $key => $value) {
            if (property_exists($responseObj, $key)) {
                $responseObj->$key = $value;
            }
        }

        return $responseObj;
    }

    /**
     * Creates a new Pix Key (DICT Entry).
     *
     * @param CreatePixKeyRequest $request
     * @param string $idempotencyKey
     * @return CreatePixKeyResponse
     * @throws Exception
     */
    public function createPixKey(CreatePixKeyRequest $request, $idempotencyKey)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v1/pix/dict/entries';
        
        $payload = [
            'entryType' => $request->entryType
        ];

        if ($request->key !== null) {
            $payload['key'] = $request->key;
        }

        $body = json_encode($payload);

        $headers = [
            'IdempotencyKey: ' . $idempotencyKey
        ];

        if ($request->authCode !== null) {
            $headers[] = 'x-auth-code: ' . $request->authCode;
        }

        if ($request->authId !== null) {
            $headers[] = 'x-auth-id: ' . $request->authId;
        }

        $response = $this->requestHelper->execute('POST', $url, $body, $headers);
        $data = json_decode($response, true);
        
        $responseObj = new CreatePixKeyResponse();
        
        // Populate response object from data
        foreach ($data as $key => $value) {
            if (property_exists($responseObj, $key)) {
                $responseObj->$key = $value;
            }
        }

        return $responseObj;
    }

    /**
     * Deletes a Pix Key (DICT Entry).
     *
     * @param DeletePixKeyRequest $request
     * @param string $idempotencyKey
     * @return DeletePixKeyResponse
     * @throws Exception
     */
    public function deletePixKey(DeletePixKeyRequest $request, $idempotencyKey)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v1/pix/dict/entries';
        
        $payload = [
            'entryType' => $request->entryType,
            'key' => $request->key
        ];

        $body = json_encode($payload);

        $headers = [
            'IdempotencyKey: ' . $idempotencyKey
        ];
        
        $response = $this->requestHelper->execute('DELETE', $url, $body, $headers);
        
        // Check if response is empty (success 204) or has content
        if (empty($response)) {
            $responseObj = new DeletePixKeyResponse();
            $responseObj->success = true;
            $responseObj->message = "Key deleted successfully.";
            return $responseObj;
        }

        $data = json_decode($response, true);
        
        $responseObj = new DeletePixKeyResponse();
        $responseObj->success = true;
        // Map any returned fields if necessary, or just return success
        
        return $responseObj;
    }

    /**
     * Lists all Pix Keys (DICT Entries).
     *
     * @return GetPixKeysResponse
     * @throws Exception
     */
    public function getPixKeys()
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v1/pix/dict/entries';
        
        $response = $this->requestHelper->execute('GET', $url);
        $data = json_decode($response, true);
        
        $responseObj = new GetPixKeysResponse();
        $responseObj->keys = $data;

        return $responseObj;
    }
}
