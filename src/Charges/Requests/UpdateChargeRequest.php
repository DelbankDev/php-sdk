<?php

namespace Delfinance\Charges\Requests;

class UpdateChargeRequest
{
    /**
     * @var string Format: yyyy-mm-dd
     */
    public $dueDate;

    /**
     * UpdateChargeRequest constructor.
     * @param string $dueDate
     */
    public function __construct($dueDate)
    {
        $this->dueDate = $dueDate;
    }
}
