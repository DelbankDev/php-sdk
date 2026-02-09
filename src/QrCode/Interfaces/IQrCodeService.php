<?php

namespace Delfinance\QrCode\Interfaces;

use Delfinance\Transfers\Requests\PaymentInitializationRequest;
use Delfinance\Transfers\Requests\DecodeQrCodeRequest;
use Delfinance\QrCode\Requests\ImmediateQrCodeRequest;
use Delfinance\QrCode\Requests\DueDateQrCodeRequest;
use Delfinance\QrCode\Requests\StaticQrCodeRequest;
use Delfinance\Transfers\Responses\PaymentInitializationResponse;
use Delfinance\Transfers\Responses\DecodeQrCodeResponse;
use Delfinance\QrCode\Responses\CreateImmediateQrCodeResponse;
use Delfinance\QrCode\Responses\CreateDueDateQrCodeResponse;
use Delfinance\QrCode\Responses\CreateStaticQrCodeResponse;

/**
 * Interface IQrCodeService
 */
interface IQrCodeService
{
    /**
     * Creates a Dynamic QR Code (Immediate).
     *
     * @param ImmediateQrCodeRequest $request
     * @return CreateImmediateQrCodeResponse
     */
    public function createImmediateQrCode(ImmediateQrCodeRequest $request);

    /**
     * Creates a Due Date QR Code.
     *
     * @param DueDateQrCodeRequest $request
     * @return CreateDueDateQrCodeResponse
     */
    public function createDueDateQrCode(DueDateQrCodeRequest $request);

    /**
     * Creates a Static QR Code.
     *
     * @param StaticQrCodeRequest $request
     * @return CreateStaticQrCodeResponse
     */
    public function createStaticQrCode(StaticQrCodeRequest $request);
}
