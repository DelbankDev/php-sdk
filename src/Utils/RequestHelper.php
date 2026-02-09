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
        } elseif ($method === 'PATCH') {
            $options[CURLOPT_CUSTOMREQUEST] = 'PATCH';
            if ($body) {
                $options[CURLOPT_POSTFIELDS] = $body;
            }
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

    /**
     * Execute a POST request and map response to object.
     *
     * @param string $url
     * @param array $bodyArray
     * @param string $responseClass
     * @return mixed
     * @throws Exception
     */
    public function post($url, $bodyArray, $responseClass)
    {
        $body = json_encode($bodyArray);
        $response = $this->execute('POST', $url, $body);
        return $this->mapResponseToObject($response, $responseClass);
    }

    /**
     * Execute a GET request and map response to object.
     *
     * @param string $url
     * @param string $responseClass
     * @return mixed
     * @throws Exception
     */
    public function get($url, $responseClass)
    {
        $response = $this->execute('GET', $url);
        return $this->mapResponseToObject($response, $responseClass);
    }

    /**
     * Execute a GET request and map response to list of objects.
     *
     * @param string $url
     * @param string $itemClass
     * @return array
     * @throws Exception
     */
    public function getList($url, $itemClass)
    {
        $response = $this->execute('GET', $url);
        return $this->mapResponseToList($response, $itemClass);
    }

    /**
     * Execute a PATCH request.
     *
     * @param string $url
     * @param array|null $bodyArray
     * @return mixed
     * @throws Exception
     */
    public function patch($url, $bodyArray = null)
    {
        $body = $bodyArray ? json_encode($bodyArray) : null;
        $response = $this->execute('PATCH', $url, $body);
        return json_decode($response, true);
    }

    /**
     * Map JSON response to Object.
     *
     * @param string $jsonResponse
     * @param string $className
     * @return mixed
     */
    private function mapResponseToObject($jsonResponse, $className)
    {
        $data = json_decode($jsonResponse, true);
        $obj = new $className();
        
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (property_exists($obj, $key)) {
                    $obj->$key = $value;
                }
            }
        }
        
        return $obj;
    }

    /**
     * Map JSON response to List of Objects.
     *
     * @param string $jsonResponse
     * @param string $className
     * @return array
     */
    private function mapResponseToList($jsonResponse, $className)
    {
        $data = json_decode($jsonResponse, true);
        
        if (!is_array($data)) {
            return [];
        }

        $results = [];
        
        // Check if sequential array (list)
        if (array_keys($data) === range(0, count($data) - 1) && !empty($data)) {
            foreach ($data as $itemData) {
                if (is_array($itemData)) {
                    $obj = new $className();
                    foreach ($itemData as $key => $value) {
                        if (property_exists($obj, $key)) {
                            $obj->$key = $value;
                        }
                    }
                    $results[] = $obj;
                }
            }
        } else if (!empty($data)) {
            // Assume single object if not sequential or empty
            $obj = new $className();
            foreach ($data as $key => $value) {
                if (property_exists($obj, $key)) {
                    $obj->$key = $value;
                }
            }
            $results[] = $obj;
        }

        return $results;
    }
}
