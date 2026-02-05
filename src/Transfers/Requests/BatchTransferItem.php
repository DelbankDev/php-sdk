<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class BatchTransferItem
 */
class BatchTransferItem
{
    /**
     * @var string
     */
    public $beneficiaryAccountNumber;

    /**
     * @var string
     */
    public $transferType;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $accountType;

    /**
     * @var string
     */
    public $agency;

    /**
     * @var string
     */
    public $bankCode;

    /**
     * @var string
     */
    public $ispbCode;

    /**
     * @var string
     */
    public $document;

    /**
     * @var string
     */
    public $idIntegration;

    /**
     * @var string
     */
    public $status;

    /**
     * BatchTransferItem constructor.
     * @param string $beneficiaryAccountNumber
     * @param string $transferType
     * @param float $amount
     * @param string $name
     * @param string $accountType
     * @param string $agency
     * @param string $bankCode
     * @param string $ispbCode
     * @param string $document
     * @param string $idIntegration
     * @param string $status
     */
    public function __construct(
        $beneficiaryAccountNumber,
        $transferType,
        $amount,
        $name,
        $accountType,
        $agency,
        $bankCode,
        $ispbCode,
        $document,
        $idIntegration,
        $status
    ) {
        $this->beneficiaryAccountNumber = $beneficiaryAccountNumber;
        $this->transferType = $transferType;
        $this->amount = $amount;
        $this->name = $name;
        $this->accountType = $accountType;
        $this->agency = $agency;
        $this->bankCode = $bankCode;
        $this->ispbCode = $ispbCode;
        $this->document = $document;
        $this->idIntegration = $idIntegration;
        $this->status = $status;
    }
}
