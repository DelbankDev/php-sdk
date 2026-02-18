<?php

namespace Delfinance\Transfers\Responses;

/**
 * Class GenerateAuthCodeResponse
 * Response for generating an authentication code.
 */
class GenerateAuthCodeResponse
{
    /**
     * @var string
     * The unique identifier for the authentication request (x-auth-id).
     */
    public $id;
}
