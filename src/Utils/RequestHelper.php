<?php

namespace Delfinance\Utils;

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Exception;

/**
 * Class RequestHelper
 */
class RequestHelper
{
    /**
     * @var DelfinanceClient
     */
    private $client;

    /**
     * RequestHelper constructor.
     * @param DelfinanceClient $client
     */
    public function __construct(DelfinanceClient $client)
    {
        $this->client = $client;
    }

    /**
     * Execute a cURL request.
     *
     * @param string $method
     * @param string $url
     * @param string|null $body
     * @param array $customHeaders
     * @return string
     * @throws Exception
     */
    public function execute($method, $url, $body = null, $customHeaders = [])
    {
        $ch = curl_init();
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'x-delbank-api-key: ' . $this->client->getApiKey(),
            'x-delfinance-account-id: ' . $this->client->getAccountId()
        ];

        if (!empty($customHeaders)) {
            $headers = array_merge($headers, $customHeaders);
        }

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
        ];

        if ($method === 'POST') {
            $options[CURLOPT_POST] = true;
            if ($body) {
                $options[CURLOPT_POSTFIELDS] = $body;
            }
        } elseif ($method === 'GET') {
            $options[CURLOPT_CUSTOMREQUEST] = 'GET';
        }

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

        return $response;
    }
}
