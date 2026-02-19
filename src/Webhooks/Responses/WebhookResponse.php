<?php

namespace Delfinance\Webhooks\Responses;

/**
 * Class WebhookResponse
 * Response for webhook operations.
 */
class WebhookResponse
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $eventType;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $authorizationScheme;

    /**
     * @var string
     */
    public $authorization;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $updatedAt;
}
