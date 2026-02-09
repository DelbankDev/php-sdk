<?php

namespace Delfinance\QrCode\Services;

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\QrCode\Dto\QrCodePaymentDTO;
use Delfinance\QrCode\Interfaces\IQrCodeService;
use Delfinance\QrCode\Requests\DueDateQrCodeRequest;
use Delfinance\QrCode\Requests\ImmediateQrCodeRequest;
use Delfinance\QrCode\Requests\StaticQrCodeRequest;
use Delfinance\QrCode\Responses\CreateDueDateQrCodeResponse;
use Delfinance\QrCode\Responses\CreateImmediateQrCodeResponse;
use Delfinance\QrCode\Responses\CreateStaticQrCodeResponse;
use Delfinance\QrCode\Responses\GetQrCodeResponse;
use Delfinance\Utils\RequestHelper;
use Exception;

/**
 * Class QrCodeService
 */
class QrCodeService implements IQrCodeService
{
    /**
     * @var DelfinanceClient
     */
    private $client;

    /**
     * @var RequestHelper
     */
    private $requestHelper;

    /**
     * QrCodeService constructor.
     * @param DelfinanceClient $client
     */
    public function __construct(DelfinanceClient $client)
    {
        $this->client = $client;
        $this->requestHelper = new RequestHelper($client);
    }

    /**
     * Creates a Dynamic QR Code (Immediate).
     *
     * @param ImmediateQrCodeRequest $request
     * @return CreateImmediateQrCodeResponse
     * @throws Exception
     */
    public function createImmediateQrCode(ImmediateQrCodeRequest $request)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/dynamic';
        
        $bodyArray = [
            'correlationId' => $request->correlationId,
            'amount' => $request->amount,
            'formatResponse' => $request->formatResponse,
            'expiresIn' => $request->expiresIn
        ];

        if ($request->pixKey) {
            $bodyArray['pixKey'] = $request->pixKey;
        }
        if ($request->payer) {
            $bodyArray['payer'] = $request->payer;
        }
        if ($request->address) {
            $bodyArray['address'] = $request->address;
        }
        if ($request->finalBeneficiary) {
            $bodyArray['finalBeneficiary'] = $request->finalBeneficiary;
        }
        if ($request->additionalInfos) {
            $bodyArray['additionalInfos'] = $request->additionalInfos;
        }
        if ($request->allowChangeAmount !== null) {
            $bodyArray['allowChangeAmount'] = $request->allowChangeAmount;
        }
        if ($request->change) {
            $bodyArray['change'] = $request->change;
        }
        if ($request->withdrawal) {
            $bodyArray['withdrawal'] = $request->withdrawal;
        }
        if ($request->splitInstructions) {
            $bodyArray['splitInstructions'] = $request->splitInstructions;
        }
        if ($request->allowedPayersAccount) {
            $bodyArray['allowedPayersAccount'] = $request->allowedPayersAccount;
        }

        return $this->requestHelper->post($url, $bodyArray, CreateImmediateQrCodeResponse::class);
    }

    /**
     * Creates a Due Date QR Code.
     *
     * @param DueDateQrCodeRequest $request
     * @return CreateDueDateQrCodeResponse
     * @throws Exception
     */
    public function createDueDateQrCode(DueDateQrCodeRequest $request)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/due-date';
        
        $bodyArray = [
            'dueDate' => $request->dueDate,
            'correlationId' => $request->correlationId,
            'amount' => $request->amount,
            'pixKey' => $request->pixKey,
            'payer' => $request->payer,
            'address' => $request->address,
            'formatResponse' => $request->formatResponse,
            'revision' => $request->revision,
            'reusable' => $request->reusable,
            'maxDaysOverdue' => $request->maxDaysOverdue
        ];

        if ($request->taxes) {
            $bodyArray['taxes'] = $request->taxes;
        }
        if ($request->additionalInfos) {
            $bodyArray['additionalInfos'] = $request->additionalInfos;
        }

        return $this->requestHelper->post($url, $bodyArray, CreateDueDateQrCodeResponse::class);
    }

    /**
     * Creates a Static QR Code.
     *
     * @param StaticQrCodeRequest $request
     * @return CreateStaticQrCodeResponse
     * @throws Exception
     */
    public function createStaticQrCode(StaticQrCodeRequest $request)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/static';
        
        $bodyArray = [
            'correlationId' => $request->correlationId,
            'formatResponse' => $request->formatResponse,
            'source' => $request->source
        ];

        if ($request->amount !== null) {
            $bodyArray['amount'] = $request->amount;
        }
        if ($request->pixKey) {
            $bodyArray['pixKey'] = $request->pixKey;
        }
        if ($request->ispbPss) {
            $bodyArray['ispbPss'] = $request->ispbPss;
        }
        if ($request->address) {
            $bodyArray['address'] = $request->address;
        }
        if ($request->beneficiaryName) {
            $bodyArray['beneficiaryName'] = $request->beneficiaryName;
        }
        if ($request->additionalInfo) {
            $bodyArray['additionalInfo'] = $request->additionalInfo;
        }

        return $this->requestHelper->post($url, $bodyArray, CreateStaticQrCodeResponse::class);
    }

    /**
     * Get Static QR Code by Transaction Identifier.
     *
     * @param string $transactionIdentifier
     * @return GetQrCodeResponse
     * @throws Exception
     */
    public function getStaticQrCode($transactionIdentifier)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/static/' . $transactionIdentifier;
        return $this->requestHelper->get($url, GetQrCodeResponse::class);
    }

    /**
     * Get Immediate QR Code by ID.
     *
     * @param string $id
     * @return QrCodeDTO
     * @throws Exception
     */
    public function getImmediateQrCode($id)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/dynamic/' . $id;
        return $this->requestHelper->get($url, GetQrCodeResponse::class);
    }

    /**
     * Get Due Date QR Code by ID.
     *
     * @param string $id
     * @return QrCodeDTO
     * @throws Exception
     */
    public function getDueDateQrCode($id)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/due-date/' . $id;
        return $this->requestHelper->get($url, GetQrCodeResponse::class);
    }

    /**
     * Get Static QR Code Payments.
     *
     * @param string $identifier
     * @return QrCodePaymentDTO[]
     * @throws Exception
     */
    public function getStaticQrCodePayments($identifier)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/static/' . $identifier . '/payments';
        return $this->requestHelper->getList($url, QrCodePaymentDTO::class);
    }

    /**
     * Cancel Static QR Code.
     *
     * @param string $transactionIdentifier
     * @return mixed
     * @throws Exception
     */
    public function cancelStaticQrCode($transactionIdentifier)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/static/' . $transactionIdentifier . '/cancel';
        return $this->requestHelper->patch($url);
    }

    /**
     * Cancel Immediate QR Code.
     *
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function cancelImmediateQrCode($id)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/dynamic/immediate-payment/' . $id . '/cancel';
        return $this->requestHelper->patch($url);
    }

    /**
     * Cancel Due Date QR Code.
     *
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function cancelDueDateQrCode($id)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v2/pix/qrcode/dynamic/due-date/' . $id . '/cancel';
        return $this->requestHelper->patch($url);
    }


}
