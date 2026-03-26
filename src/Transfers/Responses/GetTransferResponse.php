<?php

namespace Delfinance\Transfers\Responses;

/**
 * Class GetTransferResponse
 */
class GetTransferResponse
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string|null (PIX)
     */
    public $endToEndId;

    /**
     * @var int|null (PIX)
     */
    public $transactionNsu;

    /**
     * @var string|null (não usado nos exemplos, manter opcional)
     */
    public $externalId;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $type;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string|null (TED)
     */
    public $transferAt;

    /**
     * @var string|null (não presente nos payloads atuais)
     */
    public $updatedAt;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var array|null
     */
    public $error;

    /**
     * @var array|null (PIX)
     */
    public $payer;

    /**
     * @var array|null (PIX)
     */
    public $beneficiary;

    /**
     * @var array|null (TED)
     */
    public $sender;

    /**
     * @var array|null (TED)
     */
    public $recipient;

    /**
     * @var array|null (TED)
     */
    public $tags;
}
