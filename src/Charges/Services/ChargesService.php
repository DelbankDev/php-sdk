<?php

namespace Delfinance\Charges\Services;

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\Charges\Interfaces\IChargesService;
use Delfinance\Charges\Requests\CreateChargeRequest;
use Delfinance\Charges\Requests\UpdateChargeRequest;
use Delfinance\Charges\Responses\ChargeResponse;
use Delfinance\Charges\Dto\Payer;
use Delfinance\Charges\Dto\Phone;
use Delfinance\Charges\Dto\Address;
use Delfinance\Charges\Dto\Beneficiary;
use Delfinance\Charges\Dto\Discount;
use Delfinance\Charges\Dto\DiscountItem;
use Delfinance\Charges\Dto\LateFine;
use Delfinance\Charges\Dto\LatePayment;
use Delfinance\Charges\Requests\MakePaymentRequest;
use Delfinance\Charges\Responses\BillPaymentResponse;
use Delfinance\Charges\Responses\MakePaymentResponse;
use Delfinance\Charges\Responses\PaymentCalculation;
use Delfinance\Charges\Responses\BillPayer;
use Delfinance\Charges\Responses\OverduePaymentInterest;
use Delfinance\Charges\Responses\OverduePaymentFine;
use Delfinance\Charges\Responses\BillBeneficiary;
use Delfinance\Charges\Responses\Issuer;
use Delfinance\Utils\RequestHelper;
use Exception;

/**
 * Class ChargesService
 */
class ChargesService implements IChargesService
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
     * ChargesService constructor.
     * @param DelfinanceClient $client
     */
    public function __construct(DelfinanceClient $client)
    {
        $this->client = $client;
        $this->requestHelper = new RequestHelper($client);
    }

    /**
     * Creates a new Charge (Bank Slip).
     *
     * @param CreateChargeRequest $request
     * @return ChargeResponse
     * @throws Exception
     */
    public function createCharge(CreateChargeRequest $request)
    {
        $url = $this->client->getBaseUrl() . '/baas/v1/charges';
        
        // Prepare body
        $body = json_encode($request);

        $response = $this->requestHelper->execute('POST', $url, $body);
        return $this->mapResponseToCharge($response);
    }

    /**
     * Get a Charge by Correlation ID.
     *
     * @param string $correlationId
     * @return ChargeResponse
     * @throws Exception
     */
    public function getCharge($correlationId)
    {
        $url = $this->client->getBaseUrl() . '/baas/v1/charges/' . $correlationId;
        
        $response = $this->requestHelper->execute('GET', $url);
        return $this->mapResponseToCharge($response);
    }

    /**
     * Get Charges Paginated by Period.
     *
     * @param string|null $startDate Format: yyyy-mm-dd
     * @param string|null $endDate Format: yyyy-mm-dd
     * @param int|null $page
     * @param int|null $limit
     * @return ChargeResponse[]
     * @throws Exception
     */
    public function getCharges($startDate = null, $endDate = null, $page = null, $limit = null)
    {
        $url = $this->client->getBaseUrl() . '/baas/v1/charges';
        
        $queryParams = [];
        if ($startDate) $queryParams['startDate'] = $startDate;
        if ($endDate) $queryParams['endDate'] = $endDate;
        if ($page) $queryParams['page'] = $page;
        if ($limit) $queryParams['limit'] = $limit;
        
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        $response = $this->requestHelper->execute('GET', $url);
        
        // The response is an array of charges
        $data = json_decode($response, true);
        $charges = [];

        if (is_array($data)) {
            foreach ($data as $item) {
                // We can reuse mapResponseToCharge if we pass the encoded json of single item, 
                // OR we refactor mapResponseToCharge to accept array.
                // Refactoring mapResponseToCharge to accept array or decoding here.
                // To keep it simple and consistent with previous helper:
                $charges[] = $this->mapArrayToCharge($item);
            }
        }

        return $charges;
    }

    /**
     * Update a Charge (e.g. Due Date).
     *
     * @param string $correlationId
     * @param UpdateChargeRequest $request
     * @return string
     * @throws Exception
     */
    public function updateCharge($correlationId, UpdateChargeRequest $request)
    {
        $url = $this->client->getBaseUrl() . '/baas/v1/charges/' . $correlationId;
        
        $body = json_encode($request);

        // Execute PATCH request
        // The response is text/plain on success
        return $this->requestHelper->execute('PATCH', $url, $body);
    }

    /**
     * Void/Cancel a Charge.
     *
     * @param string $correlationId
     * @return string
     * @throws Exception
     */
    public function voidCharge($correlationId)
    {
        $url = $this->client->getBaseUrl() . '/baas/v1/charges/' . $correlationId . '/void';
        
        // Execute POST request
        // The response is empty body with 200 OK or 404/400 on error
        return $this->requestHelper->execute('POST', $url);
    }

    /**
     * Get Bill Payment Information by Digitable Line or Barcode.
     *
     * @param string $paymentIdentifier Digitable Line or Barcode
     * @return BillPaymentResponse
     * @throws Exception
     */
    public function getPaymentInfo($paymentIdentifier)
    {        
        $url = $this->client->getBaseUrl() . '/baas/api/v1/bill-payments/' . $paymentIdentifier;

        $response = $this->requestHelper->execute('GET', $url);
        
        return $this->mapResponseToBillPayment($response);
    }

    /**
     * Make a Bill Payment.
     *
     * @param MakePaymentRequest $request
     * @param string|null $idempotencyKey Optional UUID. If null, one will be generated.
     * @return MakePaymentResponse
     * @throws Exception
     */
    public function makePayment(MakePaymentRequest $request, $idempotencyKey = null)
    {
        $url = $this->client->getBaseUrl() . '/baas/api/v1/bill-payments';

        if (empty($idempotencyKey)) {
            $idempotencyKey = $this->generateUuid();
        }

        $headers = [
            'IdempotencyKey: ' . $idempotencyKey
        ];

        // Prepare request body
        $body = [];
        if (!empty($request->amount)) {
            $body['amount'] = $request->amount;
        }
        if (!empty($request->barCode)) {
            $body['barCode'] = $request->barCode;
        }
        if (!empty($request->digitableLine)) {
            $body['digitableLine'] = $request->digitableLine;
        }

        $response = $this->requestHelper->execute('POST', $url, json_encode($body), $headers);

        return $this->mapResponseToMakePayment($response);
    }

    private function generateUuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Helper to map JSON response to ChargeResponse object.
     * 
     * @param string $jsonResponse
     * @return ChargeResponse
     */
    private function mapResponseToCharge($jsonResponse)
    {
        $data = json_decode($jsonResponse, true);
        return $this->mapArrayToCharge($data);
    }

    /**
     * Helper to map Array data to ChargeResponse object.
     * 
     * @param array $data
     * @return ChargeResponse
     */
    private function mapArrayToCharge($data)
    {
        $charge = new ChargeResponse();
        
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if ($key === 'payer' && is_array($value)) {
                    $charge->payer = $this->mapPayer($value);
                } elseif ($key === 'beneficiary' && is_array($value)) {
                    $charge->beneficiary = $this->mapBeneficiary($value);
                } elseif ($key === 'discount' && is_array($value)) {
                    $charge->discount = $this->mapDiscount($value);
                } elseif ($key === 'lateFine' && is_array($value)) {
                    $charge->lateFine = new LateFine(
                        isset($value['type']) ? $value['type'] : '',
                        isset($value['date']) ? $value['date'] : '',
                        isset($value['amount']) ? $value['amount'] : 0.0
                    );
                } elseif ($key === 'latePayment' && is_array($value)) {
                    $charge->latePayment = new LatePayment(
                        isset($value['type']) ? $value['type'] : '',
                        isset($value['date']) ? $value['date'] : '',
                        isset($value['amount']) ? $value['amount'] : 0.0
                    );
                } elseif (property_exists($charge, $key)) {
                    $charge->$key = $value;
                }
            }
        }
        
        return $charge;
    }

    private function mapResponseToBillPayment($jsonResponse)
    {
        $data = json_decode($jsonResponse, true);
        $bill = new BillPaymentResponse();

        if (is_array($data)) {
            $bill->identifierNumber = isset($data['identifierNumber']) ? $data['identifierNumber'] : null;
            $bill->type = isset($data['type']) ? $data['type'] : null;
            $bill->status = isset($data['status']) ? $data['status'] : null;
            $bill->amount = isset($data['amount']) ? $data['amount'] : 0.0;
            $bill->dueDate = isset($data['dueDate']) ? $data['dueDate'] : null;
            $bill->barCode = isset($data['barCode']) ? $data['barCode'] : null;
            $bill->digitableLine = isset($data['digitableLine']) ? $data['digitableLine'] : null;
            $bill->isAllowPartialPayment = isset($data['isAllowPartialPayment']) ? $data['isAllowPartialPayment'] : false;
            
            if (isset($data['paymentCalculation']) && is_array($data['paymentCalculation'])) {
                $calc = new PaymentCalculation();
                $cData = $data['paymentCalculation'];
                $calc->rebateAmount = isset($cData['rebateAmount']) ? $cData['rebateAmount'] : 0.0;
                $calc->interestAmount = isset($cData['interesetAmount']) ? $cData['interesetAmount'] : (isset($cData['interestAmount']) ? $cData['interestAmount'] : 0.0);
                $calc->fineAmount = isset($cData['fineAmount']) ? $cData['fineAmount'] : 0.0;
                $calc->discountAmount = isset($cData['discountAmount']) ? $cData['discountAmount'] : 0.0;
                $calc->chargedAmount = isset($cData['chargedAmount']) ? $cData['chargedAmount'] : 0.0;
                $calc->minimumPaymentAmount = isset($cData['minimumPaymentAmount']) ? $cData['minimumPaymentAmount'] : 0.0;
                $calc->maximumPaymentAmount = isset($cData['maximumPaymentAmount']) ? $cData['maximumPaymentAmount'] : 0.0;
                $bill->paymentCalculation = $calc;
            }

            if (isset($data['payer']) && is_array($data['payer'])) {
                $payer = new BillPayer();
                $pData = $data['payer'];
                $payer->document = isset($pData['document']) ? $pData['document'] : null;
                $payer->name = isset($pData['name']) ? $pData['name'] : null;
                $payer->type = isset($pData['type']) ? $pData['type'] : null;
                $bill->payer = $payer;
            }

            if (isset($data['overduePaymentInterest']) && is_array($data['overduePaymentInterest'])) {
                $int = new OverduePaymentInterest();
                $iData = $data['overduePaymentInterest'];
                $int->date = isset($iData['date']) ? $iData['date'] : null;
                $int->amount = isset($iData['amount']) ? $iData['amount'] : 0.0;
                $int->type = isset($iData['type']) ? $iData['type'] : null;
                $bill->overduePaymentInterest = $int;
            }

            if (isset($data['overduePaymentFine']) && is_array($data['overduePaymentFine'])) {
                $fine = new OverduePaymentFine();
                $fData = $data['overduePaymentFine'];
                $fine->date = isset($fData['date']) ? $fData['date'] : null;
                $fine->amount = isset($fData['amount']) ? $fData['amount'] : 0.0;
                $fine->type = isset($fData['type']) ? $fData['type'] : null;
                $bill->overduePaymentFine = $fine;
            }

            $bill->discounts = isset($data['discounts']) ? $data['discounts'] : [];

            if (isset($data['beneficiary']) && is_array($data['beneficiary'])) {
                $ben = new BillBeneficiary();
                $bData = $data['beneficiary'];
                $ben->document = isset($bData['document']) ? $bData['document'] : null;
                $ben->name = isset($bData['name']) ? $bData['name'] : null;
                $ben->fantasyName = isset($bData['fantasyName']) ? $bData['fantasyName'] : null;
                $ben->type = isset($bData['type']) ? $bData['type'] : null;
                $bill->beneficiary = $ben;
            }

            if (isset($data['issuer']) && is_array($data['issuer'])) {
                $iss = new Issuer();
                $isData = $data['issuer'];
                $iss->ispb = isset($isData['ispb']) ? $isData['ispb'] : null;
                $iss->name = isset($isData['name']) ? $isData['name'] : null;
                $iss->nameFantasy = isset($isData['nameFantasy']) ? $isData['nameFantasy'] : null;
                $bill->issuer = $iss;
            }
        }

        return $bill;
    }

    private function mapResponseToMakePayment($jsonResponse)
    {
        $data = json_decode($jsonResponse, true);
        $payment = new MakePaymentResponse();

        if (is_array($data)) {
            $payment->id = isset($data['id']) ? $data['id'] : null;
            $payment->identifierNumber = isset($data['identifierNumber']) ? $data['identifierNumber'] : null;
            $payment->barCode = isset($data['barCode']) ? $data['barCode'] : null;
            $payment->digitableLine = isset($data['digitableLine']) ? $data['digitableLine'] : null;
            $payment->status = isset($data['status']) ? $data['status'] : null;
            $payment->dueDate = isset($data['dueDate']) ? $data['dueDate'] : null;
            $payment->createdAt = isset($data['createdAt']) ? $data['createdAt'] : null;
            $payment->originalAmount = isset($data['originalAmount']) ? $data['originalAmount'] : 0.0;
            $payment->paidAmount = isset($data['paidAmount']) ? $data['paidAmount'] : 0.0;

            if (isset($data['paymentCalculation']) && is_array($data['paymentCalculation'])) {
                $calc = new PaymentCalculation();
                $cData = $data['paymentCalculation'];
                $calc->rebateAmount = isset($cData['rebateAmount']) ? $cData['rebateAmount'] : 0.0;
                $calc->interestAmount = isset($cData['interesetAmount']) ? $cData['interesetAmount'] : (isset($cData['interestAmount']) ? $cData['interestAmount'] : 0.0);
                $calc->fineAmount = isset($cData['fineAmount']) ? $cData['fineAmount'] : 0.0;
                $calc->discountAmount = isset($cData['discountAmount']) ? $cData['discountAmount'] : 0.0;
                $calc->chargedAmount = isset($cData['chargedAmount']) ? $cData['chargedAmount'] : 0.0;
                $calc->minimumPaymentAmount = isset($cData['minimumPaymentAmount']) ? $cData['minimumPaymentAmount'] : 0.0;
                $calc->maximumPaymentAmount = isset($cData['maximumPaymentAmount']) ? $cData['maximumPaymentAmount'] : 0.0;
                $payment->paymentCalculation = $calc;
            }

            if (isset($data['beneficiary']) && is_array($data['beneficiary'])) {
                $ben = new BillBeneficiary();
                $bData = $data['beneficiary'];
                $ben->document = isset($bData['document']) ? $bData['document'] : null;
                $ben->name = isset($bData['name']) ? $bData['name'] : null;
                $ben->fantasyName = isset($bData['fantasyName']) ? $bData['fantasyName'] : null;
                $ben->type = isset($bData['type']) ? $bData['type'] : null;
                $payment->beneficiary = $ben;
            }

            if (isset($data['issuer']) && is_array($data['issuer'])) {
                $iss = new Issuer();
                $isData = $data['issuer'];
                $iss->ispb = isset($isData['ispb']) ? $isData['ispb'] : null;
                $iss->name = isset($isData['name']) ? $isData['name'] : null;
                $iss->nameFantasy = isset($isData['nameFantasy']) ? $isData['nameFantasy'] : null;
                $payment->issuer = $iss;
            }
        }
        return $payment;
    }

    private function mapPayer($data)
    {
        $phoneData = isset($data['phone']) ? $data['phone'] : [];
        $phone = new Phone(
            isset($phoneData['prefix']) ? $phoneData['prefix'] : '',
            isset($phoneData['number']) ? $phoneData['number'] : ''
        );

        $addressData = isset($data['address']) ? $data['address'] : [];
        $address = $this->mapAddress($addressData);

        return new Payer(
            isset($data['name']) ? $data['name'] : '',
            isset($data['document']) ? $data['document'] : '',
            isset($data['email']) ? $data['email'] : '',
            $phone,
            $address
        );
    }

    private function mapBeneficiary($data)
    {
        $addressData = isset($data['address']) ? $data['address'] : [];
        $address = $this->mapAddress($addressData);

        return new Beneficiary(
            isset($data['branch']) ? $data['branch'] : '',
            isset($data['bankAccount']) ? $data['bankAccount'] : '',
            isset($data['document']) ? $data['document'] : '',
            isset($data['name']) ? $data['name'] : '',
            $address
        );
    }

    private function mapAddress($data)
    {
        return new Address(
            isset($data['zipCode']) ? $data['zipCode'] : '',
            isset($data['publicPlace']) ? $data['publicPlace'] : '',
            isset($data['neighborhood']) ? $data['neighborhood'] : '',
            isset($data['number']) ? $data['number'] : '',
            isset($data['complement']) ? $data['complement'] : '',
            isset($data['city']) ? $data['city'] : '',
            isset($data['state']) ? $data['state'] : ''
        );
    }

    private function mapDiscount($data)
    {
        $items = [];
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $items[] = new DiscountItem(
                    isset($item['date']) ? $item['date'] : '',
                    isset($item['amount']) ? $item['amount'] : 0.0
                );
            }
        }

        return new Discount(
            isset($data['type']) ? $data['type'] : '',
            $items
        );
    }
}
