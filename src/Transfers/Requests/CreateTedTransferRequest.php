<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class CreateTedTransferRequest
 */
class CreateTedTransferRequest
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
     * @var array
     * Structure:
     * [
     *     "number" => "string",
     *     "branch" => "string",
     *     "type" => "string", // PAYMENT, CHECKING, etc.
     *     "participantIspb" => "string",
     *     "holder" => [
     *         "name" => "string",
     *         "document" => "string",
     *         "email" => "string",
     *         "phoneNumber" => "string",
     *         "type" => "string" // LEGAL or NATURAL
     *     ]
     * ]
     */
    public $beneficiary;

    /**
     * CreateTedTransferRequest constructor.
     * @param float $amount
     * @param string $description
     * @param array $beneficiary
     */
    public function __construct($amount, $description, array $beneficiary)
    {
        $this->amount = $amount;
        $this->description = $description;
        $this->beneficiary = $beneficiary;
    }
}
