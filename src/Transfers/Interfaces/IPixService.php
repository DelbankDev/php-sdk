<?php

namespace Delfinance\Transfers\Interfaces;

use Delfinance\Transfers\Requests\PaymentInitializationRequest;
use Delfinance\Transfers\Requests\DecodeQrCodeRequest;

/**
 * Interface IPixService
 */
interface IPixService
{
    /**
     * Initializes a Pix payment using a DICT key.
     *
     * @param PaymentInitializationRequest $request
     * @return PaymentInitializationResponse
     */
    public function paymentInitialization(PaymentInitializationRequest $request);

    /**
     * Initializes a Pix payment using a QR Code payload.
     *
     * @param DecodeQrCodeRequest $request
     * @return DecodeQrCodeResponse
     */
    public function decodeQrCode(DecodeQrCodeRequest $request);
}
