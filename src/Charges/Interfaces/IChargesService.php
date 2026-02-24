<?php

namespace Delfinance\Charges\Interfaces;

use Delfinance\Charges\Requests\CreateChargeRequest;
use Delfinance\Charges\Requests\UpdateChargeRequest;
use Delfinance\Charges\Requests\MakePaymentRequest;
use Delfinance\Charges\Responses\ChargeResponse;
use Delfinance\Charges\Responses\BillPaymentResponse;
use Delfinance\Charges\Responses\MakePaymentResponse;

/**
 * Interface IChargesService
 */
interface IChargesService
{
    /**
     * Create a new Charge.
     *
     * @param CreateChargeRequest $request
     * @return ChargeResponse
     */
    public function createCharge(CreateChargeRequest $request);

    /**
     * Get a Charge by Correlation ID.
     *
     * @param string $correlationId
     * @return ChargeResponse
     */
    public function getCharge($correlationId);

    /**
     * Get Charges by Period.
     *
     * @param string $startDate (Format: Y-m-d)
     * @param string $endDate (Format: Y-m-d)
     * @param int $page (Default: 1)
     * @param int $limit (Default: 10, Max: 100)
     * @return array
     */
    public function getCharges($startDate, $endDate, $page = 1, $limit = 10);

    /**
     * Update a Charge.
     *
     * @param string $correlationId
     * @param UpdateChargeRequest $request
     * @return ChargeResponse
     */
    public function updateCharge($correlationId, UpdateChargeRequest $request);

    /**
     * Void/Cancel a Charge.
     *
     * @param string $correlationId
     * @return string
     */
    public function voidCharge($correlationId);

    /**
     * Get Bill Payment Information by Digitable Line or Barcode.
     *
     * @param string $paymentIdentifier Digitable Line or Barcode
     * @return BillPaymentResponse
     */
    public function getPaymentInfo($paymentIdentifier);

    /**
     * Make a Bill Payment.
     *
     * @param MakePaymentRequest $request
     * @param string|null $idempotencyKey Optional UUID. If null, one will be generated.
     * @return MakePaymentResponse
     */
    public function makePayment(MakePaymentRequest $request, $idempotencyKey = null);
}
