<?php

namespace Delfinance\Transfers\Requests;

/**
 * Class CreateTransferRequest
 */
class CreateTransferRequest
{
    /**
     * @var string
     */
    public $endToEndId;

    /**
     * @var string
     */
    public $beneficiaryId;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $description;

    /**
     * @var bool
     */
    public $saveFavorite;

    /**
     * @var string
     */
    public $initiationType;

    /**
     * @var string
     */
    public $type;

    /**
     * @var object|array
     */
    public $beneficiary;

    /**
     * @var string
     */
    public $beneficiaryAccount;

    /**
     * @var string
     */
    public $transactionId;

    /**
     * @var string
     */
    public $transferAt;

    /**
     * @var array
     */
    public $tags;

    /**
     * @var string
     */
    public $externalId;

    /**
     * @var array
     */
    public $splitInstructions;

    /**
     * CreateTransferRequest constructor.
     * @param float $amount
     * @param string $description
     * @param string $endToEndId
     * @param string $initiationType
     * @param string $beneficiaryId
     * @param bool $saveFavorite
     * @param string $type
     * @param object|array $beneficiary
     * @param string $beneficiaryAccount
     * @param string $transactionId
     * @param string $transferAt
     * @param array $tags
     * @param string $externalId
     * @param array $splitInstructions
     */
    public function __construct(
        $amount,
        $description = null,
        $endToEndId = null,
        $initiationType = null,
        $beneficiaryId = null,
        $saveFavorite = false,
        $type = 'Pix',
        $beneficiary = null,
        $beneficiaryAccount = null,
        $transactionId = null,
        $transferAt = null,
        array $tags = [],
        $externalId = null,
        array $splitInstructions = []
    ) {
        $this->amount = $amount;
        $this->description = $description;
        $this->endToEndId = $endToEndId;
        $this->initiationType = $initiationType;
        $this->beneficiaryId = $beneficiaryId;
        $this->saveFavorite = $saveFavorite;
        $this->type = $type;
        $this->beneficiary = $beneficiary;
        $this->beneficiaryAccount = $beneficiaryAccount;
        $this->transactionId = $transactionId;
        $this->transferAt = $transferAt ?? gmdate('Y-m-d\TH:i:s\Z');
        $this->tags = $tags;
        $this->externalId = $externalId;
        $this->splitInstructions = $splitInstructions;
    }
}
