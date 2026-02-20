<?php

namespace Delfinance\Webhooks\Requests;

/**
 * Class UpdateWebhookRequest
 * Request payload for updating a webhook.
 */
class UpdateWebhookRequest extends CreateWebhookRequest
{
    /**
     * @var string
     * Required. The ID of the webhook to update.
     */
    public $id;

    /**
     * UpdateWebhookRequest constructor.
     * @param string $id
     * @param string $eventType
     * @param string $url
     * @param string $authorizationScheme
     * @param string $authorization
     */
    public function __construct($id, $eventType, $url, $authorizationScheme, $authorization)
    {
        parent::__construct($eventType, $url, $authorizationScheme, $authorization);
        $this->id = $id;
    }
}
