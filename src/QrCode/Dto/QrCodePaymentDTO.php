<?php

namespace Delfinance\QrCode\Dto;

/**
 * Class QrCodePaymentDTO
 */
class QrCodePaymentDTO
{
    /**
     * @var string|null
     */
    public $endToEndId;

    /**
     * @var string|null
     */
    public $correlationId;

    /**
     * @var float|null
     */
    public $amount;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var array|object|null
     */
    public $proof;
}
