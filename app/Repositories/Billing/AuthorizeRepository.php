<?php

namespace App\Repositories\Billing;

use App\Contracts\Billing\BillingRepository;
use App\Exceptions\BillingErrorException;
use App\Exceptions\BillingFailedException;
use App\Exceptions\NotImplementedException;
use App\Logging\Logger;

class AuthorizeRepository implements BillingRepository
{
    /**
     * Returns a customer id
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $phone
     * @return string
     * @throws NotImplementedException
     */
    public function createCustomer($firstName, $lastName, $email, $phone)
    {
        throw new NotImplementedException('Not Implemented');
    }

    /**
     * @param string|null $customerId
     * @return string
     * @throws NotImplementedException
     */
    public function getClientToken($customerId = null)
    {
        throw new NotImplementedException('Not Implemented');
    }

    /**
     * @param string $customerId
     * @param string $nonce
     * @return string
     * @throws NotImplementedException
     */
    public function addPaymentMethod($customerId, $nonce)
    {
        throw new NotImplementedException('Not Implemented');
    }

    /**
     * @param string  $customerId
     * @param string  $paymentMethod
     * @param integer $orderId
     * @return bool
     * @throws NotImplementedException
     */
    public function authorizeOrder($customerId, $paymentMethod, $orderId)
    {
        throw new NotImplementedException('Not Implemented');
    }

    /**
     * @param integer $orderId
     * @param float   $amount
     * @return bool
     * @throws BillingErrorException
     * @throws BillingFailedException
     */
    public function settleOrder($orderId, $amount)
    {
        $order = order_repository()->find($orderId);
        $transactionId = $order->billing_charge_id;
        try {
            if (config('greekhouse.billing.mode') != 'live') {
                return true;
            }
            $logId = Logger::logApi('Authorize priorAuthCapture', $transactionId);
            $sale = new \AuthorizeNetAIM(config('greekhouse.billing.providers.authorize.login'), config('greekhouse.billing.providers.authorize.key'));
            $sale->setSandbox(false);
            $sale->setFields([
                'amount'       => $amount,
                'test_request' => config('greekhouse.billing.mode') != 'live',
                'trans_id'     => $transactionId,
            ]);

            $result = $sale->priorAuthCapture($transactionId);
            Logger::logApiResponse($logId, $result);
            if ($result->error !== false || $result->response_code != "1") {
                throw new BillingFailedException($result->response_reason_text, print_r($result, true), $result->response_code);
            }

            $order->update([
                'state'             => 'success',
                'billing_provider'  => 'AUTHORIZE',
                'billing_charge_id' => $transactionId,
            ]);

            return true;
        } catch (BillingFailedException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            throw new BillingErrorException($ex->getMessage(), -1, $ex);
        }
    }

    /**billing_authorization_id
     *
     * @param integer $orderId
     * @return bool
     * @throws BillingErrorException
     * @throws NotImplementedException
     * @throws BillingFailedException
     */
    public function voidOrder($orderId)
    {
        $order = order_repository()->find($orderId);
        $transactionId = $order->billing_charge_id;
        try {
            if (config('greekhouse.billing.mode') != 'live') {
                return true;
            }
            $logId = Logger::logApi('Authorize voidCharge', $transactionId);
            $sale = new \AuthorizeNetAIM(config('greekhouse.billing.providers.authorize.login'), config('greekhouse.billing.providers.authorize.key'));
            $sale->setSandbox(false);
            $sale->setFields([
                'test_request' => config('greekhouse.billing.mode') != 'live',
                'trans_id'     => $transactionId,
            ]);
            $result = $sale->void($transactionId);
            Logger::logApiResponse($logId, $result);
            if ($result->error !== false || $result->response_code != "1") {
                Logger::logApiResponse($logId, $result);
                throw new BillingFailedException($result->response_reason_text, print_r($result, true), $result->response_code);
            }
            $order->update([
                'state' => 'cancelled',
            ]);

            return true;
        } catch (BillingFailedException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            throw new BillingErrorException($ex->getMessage(), -1, $ex);
        }
    }

    /**
     * @param integer $orderId
     * @return bool
     * @throws BillingErrorException
     * @throws NotImplementedException
     */
    public function refundOrder($orderId)
    {
//        $order = order_repository()->find($orderId);
//        $transactionId = $order->billing_charge_id;
//        try {
//            if (config('greekhouse.billing.mode') != 'live') {
//                return true;
//            }
//            $logId = Logger::logApi('Authorize refundCharge', $transactionId);
//            $sale = new \AuthorizeNetAIM(config('greekhouse.billing.providers.authorize.login'), config('greekhouse.billing.providers.authorize.key'));
//            $sale->setSandbox(false);
//            $sale->setFields([
//                'test_request' => config('greekhouse.billing.mode') != 'live',
//                'trans_id'     => $transactionId,
//                'card_num'     => $cardNumber,
//                'amount'       => $amount,
//            ]);
//            $result = $sale->credit($transactionId, $amount, $cardNumber);
//
//            Logger::logApiResponse($logId, $result);
//            if ($result->error !== false || $result->response_code != "1") {
//                throw new BillingFailedException($result->response_reason_text, print_r($result, true), $result->response_code);
//            }
//
//            return true;
//        } catch (BillingFailedException $ex) {
//            throw $ex;
//        } catch (\Exception $ex) {
//            throw new BillingErrorException($ex->getMessage(), -1, $ex);
//        }

//        $billing = new AuthorizeRepository();
//        $details = print_r_reverse($order->billing_details);
//        if (!is_array($details)) {
//            return form()->error('Order marked as refunded but not actually refunded on Authorize.net: #1')->back();
//        }
//        if (!isset($details['x_account_number']) || strlen(str_replace('X', '', $details['x_account_number'])) != 4) {
//            return form()->error('Order marked as refunded but not actually refunded on Authorize.net: #2')->back();
//        }
//        try {
//            $billing->refundCharge($order->billing_charge_id, $order->total, str_replace('X', '', $details['x_account_number']));
//        } catch (\Exception $ex) {
//            return form()->error('Order marked as refunded but not actually refunded on Authorize.net: ' . $ex->getMessage())->back();
//        }
        throw new NotImplementedException('Not Implemented');
    }
}
