<?php

namespace Delfinance\Webhooks\Requests;

/**
 * Class CreateWebhookRequest
 * Request payload for creating a webhook.
 */
class CreateWebhookRequest
{
    /**
     * @var string
     * Required. Event type to be monitored/listened.
     */
    public $eventType;

    /**
     * @var string
     * Required. URL of the client system API that will receive the webhook information.
     */
    public $url;

    /**
     * @var string
     * Required. Authorization scheme to be used during endpoint call (BASIC, BEARER, HEADER).
     */
    public $authorizationScheme;

    /**
     * @var string
     * Required. Information that will be sent in the request header to the endpoint.
     */
    public $authorization;

    /**
     * CreateWebhookRequest constructor.
     * @param string $eventType
     * @param string $url
     * @param string $authorizationScheme
     * @param string $authorization
     */
    public function __construct($eventType, $url, $authorizationScheme, $authorization)
    {
        $this->eventType = $eventType;
        $this->url = $url;
        $this->authorizationScheme = $authorizationScheme;
        $this->authorization = $authorization;
    }
}
