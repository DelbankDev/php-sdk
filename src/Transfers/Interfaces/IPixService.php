<?php

namespace Delfinance\Transfers\Interfaces;

use Delfinance\Transfers\Requests\PaymentInitializationRequest;
use Delfinance\Transfers\Requests\DecodeQrCodeRequest;
use Delfinance\Transfers\Requests\CreatePixKeyRequest;
use Delfinance\Transfers\Requests\DeletePixKeyRequest;
use Delfinance\Transfers\Responses\PaymentInitializationResponse;
use Delfinance\Transfers\Responses\DecodeQrCodeResponse;
use Delfinance\Transfers\Responses\CreatePixKeyResponse;
use Delfinance\Transfers\Responses\DeletePixKeyResponse;
use Delfinance\Transfers\Responses\GetPixKeysResponse;

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

    /**
     * Creates a new Pix Key (DICT Entry).
     *
     * @param CreatePixKeyRequest $request
     * @param string $idempotencyKey
     * @return CreatePixKeyResponse
     */
    public function createPixKey(CreatePixKeyRequest $request, $idempotencyKey);

    /**
     * Deletes a Pix Key (DICT Entry).
     *
     * @param DeletePixKeyRequest $request
     * @param string $idempotencyKey
     * @return DeletePixKeyResponse
     */
    public function deletePixKey(DeletePixKeyRequest $request, $idempotencyKey);

    /**
     * Lists all Pix Keys (DICT Entries).
     *
     * @return GetPixKeysResponse
     */
    public function getPixKeys();
}
