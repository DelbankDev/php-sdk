<?php

namespace Delfinance\Webhooks\Interfaces;

use Delfinance\Webhooks\Requests\CreateWebhookRequest;
use Delfinance\Webhooks\Requests\UpdateWebhookRequest;
use Delfinance\Webhooks\Responses\WebhookResponse;
use Delfinance\Webhooks\Responses\ListWebhooksResponse;

/**
 * Interface IWebhookService
 */
interface IWebhookService
{
    /**
     * Creates a new Webhook.
     *
     * @param CreateWebhookRequest $request
     * @return WebhookResponse
     */
    public function createWebhook(CreateWebhookRequest $request);

    /**
     * Retrieves all Webhooks.
     *
     * @return ListWebhooksResponse
     */
    public function getAllWebhooks();

    /**
     * Retrieves a Webhook by ID.
     *
     * @param string $id
     * @return WebhookResponse
     */
    public function getWebhookById($id);

    /**
     * Updates a Webhook by ID.
     *
     * @param UpdateWebhookRequest $request
     * @return WebhookResponse
     */
    public function updateWebhook(UpdateWebhookRequest $request);

    /**
     * Deletes a Webhook by ID.
     *
     * @param string $id
     * @return void
     */
    public function deleteWebhook($id);
}
