<?php

namespace Delfinance\Charges\Responses;

class BillPaymentResponse
{
    /** @var string */
    public $identifierNumber;
    /** @var string */
    public $type;
    /** @var string */
    public $status;
    /** @var float */
    public $amount;
    /** @var string */
    public $dueDate;
    /** @var string */
    public $barCode;
    /** @var string */
    public $digitableLine;
    /** @var bool */
    public $isAllowPartialPayment;
    /** @var PaymentCalculation */
    public $paymentCalculation;
    /** @var BillPayer */
    public $payer;
    /** @var OverduePaymentInterest */
    public $overduePaymentInterest;
    /** @var OverduePaymentFine */
    public $overduePaymentFine;
    /** @var array */
    public $discounts;
    /** @var BillBeneficiary */
    public $beneficiary;
    /** @var Issuer */
    public $issuer;
}

class PaymentCalculation
{
    /** @var float */
    public $rebateAmount;
    /** @var float */
    public $interestAmount;
    /** @var float */
    public $fineAmount;
    /** @var float */
    public $discountAmount;
    /** @var float */
    public $chargedAmount;
    /** @var float */
    public $minimumPaymentAmount;
    /** @var float */
    public $maximumPaymentAmount;
}

class BillPayer
{
    /** @var string */
    public $document;
    /** @var string */
    public $name;
    /** @var string */
    public $type;
}

class OverduePaymentInterest
{
    /** @var string */
    public $date;
    /** @var float */
    public $amount;
    /** @var string */
    public $type;
}

class OverduePaymentFine
{
    /** @var string */
    public $date;
    /** @var float */
    public $amount;
    /** @var string */
    public $type;
}

class BillBeneficiary
{
    /** @var string */
    public $document;
    /** @var string */
    public $name;
    /** @var string */
    public $fantasyName;
    /** @var string */
    public $type;
}

class Issuer
{
    /** @var string */
    public $ispb;
    /** @var string */
    public $name;
    /** @var string */
    public $nameFantasy;
}
