<?php

namespace Delfinance\Transfers\Services;

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\Transfers\Interfaces\IPixService;
use Delfinance\Transfers\Requests\PaymentInitializationRequest;
use Delfinance\Transfers\Requests\DecodeQrCodeRequest;
use Delfinance\Transfers\Responses\PaymentInitializationResponse;
use Delfinance\Transfers\Responses\DecodeQrCodeResponse;
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
     * PixService constructor.
     * @param DelfinanceClient $client
     */
    public function __construct(DelfinanceClient $client)
    {
        $this->client = $client;
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
        
        $body = json_encode([
            'key' => $request->key,
            'holderDocument' => $request->holderDocument
        ]);

        // Configuração do cURL
        $ch = curl_init();
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'x-delbank-api-key: ' . $this->client->getApiKey(),
            'x-delfinance-account-id: ' . $this->client->getAccountId()
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
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

        // Configuração do cURL
        $ch = curl_init();
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'x-delbank-api-key: ' . $this->client->getApiKey(),
            'x-delfinance-account-id: ' . $this->client->getAccountId()
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            // Timeout padrao
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
        
        $responseObj = new DecodeQrCodeResponse();
        
        foreach ($data as $key => $value) {
            if (property_exists($responseObj, $key)) {
                $responseObj->$key = $value;
            }
        }

        return $responseObj;
    }
}
