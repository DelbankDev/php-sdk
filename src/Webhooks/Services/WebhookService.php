<?php

namespace Delfinance\Webhooks\Services;

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\Webhooks\Interfaces\IWebhookService;
use Delfinance\Webhooks\Requests\CreateWebhookRequest;
use Delfinance\Webhooks\Requests\UpdateWebhookRequest;
use Delfinance\Webhooks\Responses\WebhookResponse;
use Delfinance\Webhooks\Responses\ListWebhooksResponse;
use Delfinance\Utils\RequestHelper;
use Exception;

/**
 * Class WebhookService
 */
class WebhookService implements IWebhookService
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
     * WebhookService constructor.
     * @param DelfinanceClient $client
     */
    public function __construct(DelfinanceClient $client)
    {
        $this->client = $client;
        $this->requestHelper = new RequestHelper($client);
    }

    /**
     * Creates a new Webhook.
     *
     * @param CreateWebhookRequest $request
     * @return WebhookResponse
     * @throws Exception
     */
    public function createWebhook(CreateWebhookRequest $request)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v1/webhooks';
        
        $body = json_encode([
            'eventType' => $request->eventType,
            'url' => $request->url,
            'authorizationScheme' => $request->authorizationScheme,
            'authorization' => $request->authorization
        ]);

        $response = $this->requestHelper->execute('POST', $url, $body);
        return $this->mapResponseToWebhook($response);
    }

    /**
     * Retrieves all Webhooks.
     *
     * @return ListWebhooksResponse
     * @throws Exception
     */
    public function getAllWebhooks()
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v1/webhooks';
        
        $response = $this->requestHelper->execute('GET', $url);
        $data = json_decode($response, true);
        
        $responseObj = new ListWebhooksResponse();
        
        if (is_array($data)) {
            foreach ($data as $item) {
                $webhook = new WebhookResponse();
                foreach ($item as $key => $value) {
                    if (property_exists($webhook, $key)) {
                        $webhook->$key = $value;
                    }
                }
                $responseObj->webhooks[] = $webhook;
            }
        }

        return $responseObj;
    }

    /**
     * Retrieves a Webhook by ID.
     *
     * @param string $id
     * @return WebhookResponse
     * @throws Exception
     */
    public function getWebhookById($id)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v1/webhooks/' . $id;
        
        $response = $this->requestHelper->execute('GET', $url);
        return $this->mapResponseToWebhook($response);
    }

    /**
     * Updates a Webhook by ID.
     *
     * @param UpdateWebhookRequest $request
     * @return WebhookResponse
     * @throws Exception
     */
    public function updateWebhook(UpdateWebhookRequest $request)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v1/webhooks/' . $request->id;
        
        $body = json_encode([
            'eventType' => $request->eventType,
            'url' => $request->url,
            'authorizationScheme' => $request->authorizationScheme,
            'authorization' => $request->authorization
        ]);

        $response = $this->requestHelper->execute('PATCH', $url, $body);
        return $this->mapResponseToWebhook($response);
    }

    /**
     * Deletes a Webhook by ID.
     *
     * @param string $id
     * @return void
     * @throws Exception
     */
    public function deleteWebhook($id)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v1/webhooks/' . $id;
        $this->requestHelper->execute('DELETE', $url);
    }

    /**
     * Helper to map JSON response to WebhookResponse object.
     * 
     * @param string $jsonResponse
     * @return WebhookResponse
     */
    private function mapResponseToWebhook($jsonResponse)
    {
        $data = json_decode($jsonResponse, true);
        $webhook = new WebhookResponse();
        
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (property_exists($webhook, $key)) {
                    $webhook->$key = $value;
                }
            }
        }
        
        return $webhook;
    }
}
