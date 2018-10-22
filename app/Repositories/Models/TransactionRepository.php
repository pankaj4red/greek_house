<?php

namespace App\Repositories\Models;

use App\Exceptions\BillingException;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Collection;

/**
 * @method Order make()
 * @method Collection|Order[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Order|null find($id)
 * @method Order create(array $parameters = [])
 */
class TransactionRepository extends ModelRepository
{
    protected $modelClassName = Transaction::class;

    protected $responseShow = [
        1,
        2,
        3,
        4,
        6,
        7,
        8,
        11,
        16,
        17,
        25,
        26,
        27,
        28,
        37,
        44,
        45,
        57,
        58,
        59,
        60,
        61,
        62,
        63,
        65,
        66,
        78,
        128,
        131,
        132,
        315,
        316,
        317,
        318,
        319,
    ];

    protected $responseCode = [
        1   => 'This transaction has been approved.',
        2   => 'This transaction has been declined.',
        3   => 'This transaction has been declined.',
        4   => 'This transaction has been declined.',
        5   => 'A valid amount is required.',
        6   => 'The credit card number is invalid.',
        7   => 'The credit card expiration date is invalid.',
        8   => 'The credit card has expired.',
        9   => 'The ABA code is invalid.',
        10  => 'The account number is invalid.',
        11  => 'A duplicate transaction has been submitted.',
        12  => 'An authorization code is required but not present.',
        13  => 'The merchant API Login ID is invalid or the account is inactive.',
        14  => 'The Referrer or Relay Response URL is invalid.',
        15  => 'The transaction ID is invalid.',
        16  => 'The transaction was not found.',
        17  => 'The merchant does not accept this type of credit card.',
        18  => 'ACH transactions are not accepted by this merchant.',
        19  => 'An error occurred during processing.',
        20  => 'An error occurred during processing.',
        21  => 'An error occurred during processing.',
        22  => 'An error occurred during processing.',
        23  => 'An error occurred during processing.',
        24  => 'The Nova Bank Number or Terminal ID is incorrect. Call Merchant Service Provider.',
        25  => 'An error occurred during processing. Please try again in 5 minutes.',
        26  => 'An error occurred during processing. Please try again in 5 minutes.',
        27  => 'The transaction resulted in an AVS mismatch. The address provided does not match billing address of cardholder.',
        28  => 'The merchant does not accept this type of credit card.',
        29  => 'The Paymentech identification numbers are incorrect. Call Merchant Service Provider.',
        30  => 'The configuration with the processor is invalid. Call Merchant Service Provider.',
        31  => 'The FDC Merchant ID or Terminal ID is incorrect. Call Merchant Service Provider.',
        32  => 'This reason code is reserved or not applicable to this API.',
        33  => 'FIELD cannot be left blank.',
        34  => 'The VITAL identification numbers are incorrect. Call Merchant Service Provider.',
        35  => 'An error occurred during processing. Call Merchant Service Provider.',
        36  => 'The authorization was approved, but settlement failed.',
        37  => 'The credit card number is invalid.',
        38  => 'The Global Payment System identification numbers are incorrect. Call Merchant Service Provider.',
        40  => 'This transaction must be encrypted.',
        41  => 'This transaction has been declined. This code is returned if a transaction’s fraud score is higher than the threshold set by the merchant.',
        43  => 'The merchant was incorrectly set up at the processor. Call your Merchant Service Provider.',
        44  => 'This transaction has been declined.',
        45  => 'This transaction has been declined.',
        46  => 'Your session has expired or does not exist.',
        47  => 'The amount requested for settlement may not be greater than the original amount authorized.',
        48  => 'This processor does not accept partial reversals.',
        49  => 'A transaction amount greater than $[amount] will not be accepted.',
        50  => 'This transaction is awaiting settlement and cannot be refunded.',
        51  => 'The sum of all credits against this transaction is greater than the original transaction amount.',
        52  => 'The transaction was authorized, but the client could not be notified; the transaction will not be settled.',
        53  => 'The transaction type was invalid for ACH transactions.',
        54  => 'The referenced transaction does not meet the criteria for issuing a credit.',
        55  => 'The sum of credits against the referenced transaction would exceed the original debit amount.',
        56  => 'This merchant accepts ACH transactions only; no credit card transactions are accepted.',
        57  => 'An error occurred in processing. Please try again in 5 minutes.',
        58  => 'An error occurred in processing. Please try again in 5 minutes.',
        59  => 'An error occurred in processing. Please try again in 5 minutes.',
        60  => 'An error occurred in processing. Please try again in 5 minutes.',
        61  => 'An error occurred in processing. Please try again in 5 minutes.',
        62  => 'An error occurred in processing. Please try again in 5 minutes.',
        63  => 'An error occurred in processing. Please try again in 5 minutes.',
        65  => 'This transaction has been declined.',
        66  => 'This transaction cannot be accepted for processing.',
        68  => 'The version parameter is invalid.',
        69  => 'The transaction type is invalid.',
        70  => 'The transaction method is invalid.',
        71  => 'The bank account type is invalid.',
        72  => 'The authorization code is invalid.',
        73  => 'The driver’s license date of birth is invalid.',
        74  => 'The duty amount is invalid.',
        75  => 'The freight amount is invalid.',
        76  => 'The tax amount is invalid.',
        77  => 'The SSN or tax ID is invalid.',
        78  => 'The Card Code (CVV2/CVC2/CID) is invalid.',
        79  => 'The driver’s license number is invalid.',
        80  => 'The driver’s license state is invalid.',
        81  => 'The requested form type is invalid.',
        82  => 'Scripts are only supported in version 2.5.',
        83  => 'The requested script is either invalid or no longer supported.',
        84  => 'This reason code is reserved or not applicable to this API.',
        85  => 'This reason code is reserved or not applicable to this API.',
        86  => 'This reason code is reserved or not applicable to this API.',
        87  => 'This reason code is reserved or not applicable to this API.',
        88  => 'This reason code is reserved or not applicable to this API.',
        89  => 'This reason code is reserved or not applicable to this API.',
        90  => 'This reason code is reserved or not applicable to this API.',
        91  => 'Version 2.5 is no longer supported.',
        92  => 'The gateway no longer supports the requested method of integration.',
        97  => 'This transaction cannot be accepted.',
        98  => 'This transaction cannot be accepted.',
        99  => 'This transaction cannot be accepted.',
        100 => 'The eCheck.Net type is invalid.',
        101 => 'The given name on the account and/or the account type does not match the actual account.',
        102 => 'This request cannot be accepted.',
        103 => 'This transaction cannot be accepted.',
        104 => 'This transaction is currently under review.',
        105 => 'This transaction is currently under review.',
        106 => 'This transaction is currently under review.',
        107 => 'This transaction is currently under review.',
        108 => 'This transaction is currently under review.',
        109 => 'This transaction is currently under review.',
        110 => 'This transaction is currently under review.',
        120 => 'An error occurred during processing. Please try again.',
        121 => 'An error occurred during processing. Please try again.',
        122 => 'An error occurred during processing. Please try again.',
        123 => 'This account has not been given the permission(s) required for this request.',
        127 => 'The transaction resulted in an AVS mismatch.',
        128 => 'This transaction cannot be processed.',
        130 => 'This payment gateway account has been closed.',
        131 => 'This transaction cannot be accepted at this time.',
        132 => 'This transaction cannot be accepted at this time.',
        145 => 'This transaction has been declined.',
        152 => 'The transaction was authorized, but the client could not be notified; the transaction will not be settled.',
        165 => 'This transaction has been declined.',
        170 => 'An error occurred during processing.',
        171 => 'An error occurred during processing.',
        172 => 'An error occurred during processing.',
        173 => 'An error occurred during processing.',
        174 => 'The transaction type is invalid. Please contact the merchant.',
        175 => 'The processor does not allow voiding of credits.',
        180 => 'An error occurred during processing.',
        181 => 'An error occurred during processing.',
        185 => 'This reason code is reserved or not applicable to this API.',
        193 => 'The transaction is currently under review.',
        200 => 'This transaction has been declined.',
        201 => 'This transaction has been declined.',
        202 => 'This transaction has been declined.',
        203 => 'This transaction has been declined.',
        204 => 'This transaction has been declined.',
        205 => 'This transaction has been declined.',
        206 => 'This transaction has been declined.',
        207 => 'This transaction has been declined.',
        208 => 'This transaction has been declined.',
        209 => 'This transaction has been declined.',
        210 => 'This transaction has been declined.',
        211 => 'This transaction has been declined.',
        212 => 'This transaction has been declined.',
        213 => 'This transaction has been declined.',
        214 => 'This transaction has been declined.',
        215 => 'This transaction has been declined.',
        216 => 'This transaction has been declined.',
        217 => 'This transaction has been declined.',
        218 => 'This transaction has been declined.',
        219 => 'This transaction has been declined.',
        220 => 'This transaction has been declined.',
        221 => 'This transaction has been declined.',
        222 => 'This transaction has been declined.',
        223 => 'This transaction has been declined.',
        224 => 'This transaction has been declined.',
        243 => 'Recurring billing is not allowed for this eCheck.Net type.',
        244 => 'This eCheck.Net type is not allowed for this Bank Account Type.',
        245 => 'This eCheck.Net type is not allowed when using the payment gateway hosted payment form.',
        246 => 'This eCheck.Net type is not allowed. The merchant’s payment gateway account is not enabled to submit the eCheck.Net type.',
        247 => 'This eCheck.Net type is not allowed.',
        250 => 'This transaction has been declined.',
        251 => 'This transaction has been declined.',
        252 => 'Your order has been received. Thank you for your business!',
        253 => 'Your order has been received. Thank you for your business!',
        254 => 'Your transaction has been declined. The transaction was declined after manual review.',
        261 => 'An error occurred during processing. Please try again.',
        270 => 'The line item [item number] is invalid.',
        271 => 'The number of line items submitted is not allowed. A maximum of 30 line items can be submitted.',
        288 => 'Merchant is not registered as a Cardholder Authentication participant.',
        289 => 'This processor does not accept zero dollar authorization for this card type.',
        290 => 'One or more required AVS values for zero dollar authorization were not submitted.',
        295 => 'The amount of this request was only partially approved on the given prepaid credit card. A second credit card is required to complete the balance of this transaction.',
        296 => 'The specified SplitTenderId is not valid.',
        297 => 'A Transaction ID and a Split Tender ID',
        300 => 'The device ID is invalid.',
        301 => 'The device batch ID is invalid.',
        303 => 'The device batch is full. Please close the batch.',
        304 => 'The original transaction is in a closed batch.',
        305 => 'The merchant is configured for autoclose.',
        306 => 'The batch is already closed.',
        307 => 'The reversal was processed successfully.',
        308 => 'Original transaction for reversal not found.',
        309 => 'The device has been disabled.',
        310 => 'This transaction has already been voided.',
        311 => 'This transaction has already been captured',
        312 => 'The specified security code was invalid.',
        313 => 'The customer requested a new security xode.',
        315 => 'The credit card number is invalid.',
        316 => 'The credit card expiration date is invalid.',
        317 => 'The credit card has expired.',
        318 => 'A duplicate transaction has been submitted.',
        319 => 'The transaction cannot be found.',
    ];

    protected function field($request, $key)
    {
        return is_array($request) && array_key_exists($key, $request) && $request[$key] ? $request[$key] : null;
    }

    protected function status($request)
    {
        if (! $this->field($request, 'x_response_code')) {
            return 'unknown';
        }

        switch ((int) $this->field($request, 'x_response_code')) {
            case 1:
                return 'approved';
            case 2:
                return 'declined';
            case 3:
                return 'error';
            case 4:
                return 'held_in_review';
        }

        return 'unknown';
    }

    protected function display($request)
    {
        if (! $this->field($request, 'x_response_reason_code')) {
            return 'An internal error occurred. Please try again later.';
        }

        if (in_array($this->field($request, 'x_response_reason_code'), [$this->responseShow])) {
            return $this->field($request, 'x_response_reason_text') ?? 'An internal error occurred. Please try again later.';
        }

        switch ($this->status($request)) {
            case 'approved':
                return 'This transaction has been approved.';
            case 'declined':
                return 'This transaction has been declined.';
            case 'error':
                return 'An error occurred during processing.';
            case 'held_in_review':
                return 'This transaction is currently under review';
        }

        return 'Unknown transaction status.';
    }

    protected function order($request)
    {
        return $this->field($request, 'x_invoice_num');
    }

    protected function campaign($request)
    {
        $orderId = $this->order($request);
        if (! $orderId) {
            return null;
        }

        $order = order_repository()->find($orderId);

        return $order ? $order->campaign_id : null;
    }

    /**
     * @param $request
     * @return Transaction
     * @throws BillingException
     */
    public function register($request)
    {
        return Transaction::query()->create([
            'campaign_id'                    => $this->campaign($request),
            'order_id'                       => $this->order($request),
            'status'                         => $this->status($request),
            'response_reason_text_displayed' => $this->display($request),
            'x_response_code'                => is_array($request) && array_key_exists('x_response_code', $request) ? $request['x_response_code'] : null,
            'x_response_reason_code'         => is_array($request) && array_key_exists('x_response_reason_code', $request) ? $request['x_response_reason_code'] : null,
            'x_response_reason_text'         => is_array($request) && array_key_exists('x_response_reason_text', $request) ? $request['x_response_reason_text'] : null,
            'x_auth_code'                    => is_array($request) && array_key_exists('x_auth_code', $request) ? $request['x_auth_code'] : null,
            'x_trans_id'                     => is_array($request) && array_key_exists('x_trans_id', $request) ? $request['x_trans_id'] : null,
            'x_invoice_num'                  => is_array($request) && array_key_exists('x_invoice_num', $request) ? $request['x_invoice_num'] : null,
            'x_description'                  => is_array($request) && array_key_exists('x_description', $request) ? $request['x_description'] : null,
            'x_amount'                       => is_array($request) && array_key_exists('x_amount', $request) ? $request['x_amount'] : null,
            'x_tax'                          => is_array($request) && array_key_exists('x_tax', $request) ? $request['x_tax'] : null,
            'x_method'                       => is_array($request) && array_key_exists('x_method', $request) ? $request['x_method'] : null,
            'x_type'                         => is_array($request) && array_key_exists('x_type', $request) ? $request['x_type'] : null,
            'x_MD5_Hash'                     => is_array($request) && array_key_exists('x_MD5_Hash', $request) ? $request['x_MD5_Hash'] : null,
            'x_cvv2_resp_code'               => is_array($request) && array_key_exists('x_cvv2_resp_code', $request) ? $request['x_cvv2_resp_code'] : null,
        ]);
    }
}
