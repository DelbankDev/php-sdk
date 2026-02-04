<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class CreateTransferResponse
 */
class CreateTransferRequest
{
    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $endToEndId;

    /**
     * @var string
     */
    public $initiationType;

    /**
     * TransferRequest constructor.
     * @param float $amount
     * @param string $description
     * @param string $endToEndId
     * @param string $initiationType
     */
    public function __construct($amount, $description, $endToEndId, $initiationType = 'KEY')
    {
        $this->amount = $amount;
        $this->description = $description;
        $this->endToEndId = $endToEndId;
        $this->initiationType = $initiationType;
    }
}
