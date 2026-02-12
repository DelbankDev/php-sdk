<?php

namespace Delfinance\Abstractions\Startup;

use Delfinance\Abstractions\Enums\Environment;
use Exception;

/**
 * Class DelfinanceClient
 * Main entry point for the SDK configuration and initialization.
 */
class DelfinanceClient
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var string|null
     */
    private $certificatePath;

    /**
     * @var string|null
     */
    private $privateKeyPath;

    /**
     * DelfinanceClient constructor.
     *
     * @param array $config Configuration options:
     *                      - apiKey: (string) Your API Key
     *                      - accountId: (string) Your Account ID (x-delfinance-account-id)
     *                      - environment: (string) Environment::SANDBOX or Environment::PRODUCTION
     *                      - certificatePath: (string) Path to the client certificate (PEM) for mTLS
     *                      - privateKeyPath: (string) Path to the private key (PEM) for mTLS
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $this->validateConfig($config);

        $this->apiKey = $config['apiKey'];
        $this->accountId = $config['accountId'];
        $this->environment = $config['environment'];
        $this->certificatePath = isset($config['certificatePath']) ? $config['certificatePath'] : null;
        $this->privateKeyPath = isset($config['privateKeyPath']) ? $config['privateKeyPath'] : null;
    }

    /**
     * Validates the configuration array.
     *
     * @param array $config
     * @throws Exception
     */
    private function validateConfig(array $config)
    {
        if (empty($config['apiKey'])) {
            throw new Exception("API Key is required.");
        }

        if (empty($config['accountId'])) {
            throw new Exception("Account ID is required.");
        }

        if (empty($config['environment'])) {
            throw new Exception("Environment is required.");
        }

        if (!in_array($config['environment'], [Environment::SANDBOX, Environment::PRODUCTION])) {
            throw new Exception("Invalid environment.");
        }

        // Validate mTLS files if provided
        if (!empty($config['certificatePath']) && !file_exists($config['certificatePath'])) {
             throw new Exception("Certificate file not found at: " . $config['certificatePath']);
        }

        if (!empty($config['privateKeyPath']) && !file_exists($config['privateKeyPath'])) {
             throw new Exception("Private key file not found at: " . $config['privateKeyPath']);
        }
    }

    /**
     * Get the configured API Key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Get the configured Account ID.
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Get the configured Environment.
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Get the path to the client certificate.
     *
     * @return string|null
     */
    public function getCertificatePath()
    {
        return $this->certificatePath;
    }

    /**
     * Get the path to the private key.
     *
     * @return string|null
     */
    public function getPrivateKeyPath()
    {
        return $this->privateKeyPath;
    }

    /**
     * Get the Base URL based on the environment.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        if ($this->environment === Environment::PRODUCTION) {
            return 'https://api.delbank.com.br';
        }

        return 'https://apisandbox.delbank.com.br';
    }
}
