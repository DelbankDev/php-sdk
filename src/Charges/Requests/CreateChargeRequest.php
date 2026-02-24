<?php

namespace Delfinance\Charges\Requests;

use Delfinance\Charges\Dto\Payer;

/**
 * Class CreateChargeRequest
 */
class CreateChargeRequest
{
    /**
     * @var string
     */
    public $type = 'BANKSLIP';

    /**
     * @var string
     */
    public $correlationId;

    /**
     * @var string
     */
    public $yourNumber;

    /**
     * @var string
     */
    public $dueDate;

    /**
     * @var float
     */
    public $Amount;

    /**
     * @var Payer
     */
    public $payer;

    /**
     * CreateChargeRequest constructor.
     * @param string $correlationId
     * @param string $yourNumber
     * @param string $dueDate
     * @param float $amount Note: mapped to property Amount (capitalized per spec)
     * @param Payer $payer
     */
    public function __construct($correlationId, $yourNumber, $dueDate, $amount, Payer $payer)
    {
        $this->correlationId = $correlationId;
        $this->yourNumber = $yourNumber;
        $this->dueDate = $dueDate;
        $this->Amount = $amount;
        $this->payer = $payer;
    }
}
