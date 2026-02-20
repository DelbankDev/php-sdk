<?php

namespace Delfinance\Charges\Responses;

use Delfinance\Charges\Dto\Payer;
use Delfinance\Charges\Dto\Beneficiary;
use Delfinance\Charges\Dto\Discount;
use Delfinance\Charges\Dto\LateFine;
use Delfinance\Charges\Dto\LatePayment;

/**
 * Class ChargeResponse
 */
class ChargeResponse
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $correlationId;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $walletNumber;

    /**
     * @var string
     */
    public $yourNumber;

    /**
     * @var string
     */
    public $ourNumber;

    /**
     * @var string
     */
    public $dueDate;

    /**
     * @var string
     */
    public $barCode;

    /**
     * @var string
     */
    public $digitableLine;

    /**
     * @var Payer
     */
    public $payer;

    /**
     * @var Beneficiary
     */
    public $beneficiary;

    /**
     * @var Discount
     */
    public $discount;

    /**
     * @var LateFine
     */
    public $lateFine;

    /**
     * @var LatePayment
     */
    public $latePayment;

    /**
     * @var string
     */
    public $status;

    /**
     * @var array
     */
    public $payments;

    /**
     * @var array
     */
    public $additionalInfo;

    /**
     * @var string
     */
    public $updatedAt;

    /**
     * @var string
     */
    public $createdAt;
}
