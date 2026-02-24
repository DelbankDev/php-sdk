<?php

namespace Delfinance\Charges\Responses;

class MakePaymentResponse
{
    /** @var string */
    public $id;
    /** @var string */
    public $identifierNumber;
    /** @var string */
    public $barCode;
    /** @var string */
    public $digitableLine;
    /** @var string */
    public $status;
    /** @var string */
    public $dueDate;
    /** @var string */
    public $createdAt;
    /** @var float */
    public $originalAmount;
    /** @var float */
    public $paidAmount;
    /** @var PaymentCalculation */
    public $paymentCalculation;
    /** @var BillBeneficiary */
    public $beneficiary;
    /** @var Issuer */
    public $issuer;
}
