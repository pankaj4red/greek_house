<?php

namespace App\Repositories\Billing;

use App\Contracts\Billing\BillingRepository;
use App\Exceptions\BillingErrorException;
use App\Exceptions\NotImplementedException;
use App\Logging\Logger;
use Braintree_Gateway;
use Exception;

class BrainTreeRepository implements BillingRepository
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Braintree_Gateway([
            'environment' => config('greekhouse.billing.providers.braintree.environment'),
            'merchantId'  => config('greekhouse.billing.providers.braintree.merchantId'),
            'publicKey'   => config('greekhouse.billing.providers.braintree.publicKey'),
            'privateKey'  => config('greekhouse.billing.providers.braintree.privateKey'),
        ]);
    }

    /**
     * Returns a customer id
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $phone
     * @return string
     * @throws BillingErrorException
     */
    public function createCustomer($firstName, $lastName, $email, $phone)
    {
        $result = $this->gateway->customer()->create([
            'firstName' => $firstName,
            'lastName'  => $lastName,
            'email'     => $email,
            'phone'     => $phone,
        ]);

        if ($result->success) {
            return $result->customer->id;
        }

        throw new BillingErrorException('Unable to create vault');
    }

    /**
     * @param string $customerId
     * @return string
     */
    public function getClientToken($customerId = null)
    {
        return $this->gateway->clientToken()->generate($customerId ? ["customerId" => $customerId] : []);
    }

    /**
     * @param string $customerId
     * @param string $nonce
     * @return string
     * @throws BillingErrorException
     */
    public function addPaymentMethod($customerId, $nonce)
    {
        $result = $this->gateway->paymentMethod()->create([
            'customerId'         => $customerId,
            'paymentMethodNonce' => $nonce,
        ]);

        if (! $result->success) {
            throw new BillingErrorException($result->message);
        }

        return $result->paymentMethod->token;
    }

    /**
     * @param string  $customerId
     * @param string  $paymentMethod
     * @param integer $orderId
     * @return bool
     * @throws BillingErrorException
     */
    public function authorizeOrder($customerId, $paymentMethod, $orderId)
    {
        $order = order_repository()->find($orderId);
        $order->updateMetadata();
        if ($order->state != 'new') {
            throw new BillingErrorException('Order not available for authorization');
        }

        $transactionInformation = [
            'order_id'                  => $order->id,
            'action'                    => 'authorization',
            'amount'                    => $order->total,
            'billing_provider'          => 'braintree',
            'billing_customer_id'       => $customerId,
            'billing_payment_method'    => 'card',
            'billing_payment_method_id' => $paymentMethod,
        ];

        $logId = Logger::logApi('Braintree authorize', $orderId);
        $result = $this->gateway->transaction()->sale([
            'orderId'            => $order->id,
            'amount'             => $order->total,
            'paymentMethodToken' => $paymentMethod,
            'options'            => [
                'submitForSettlement' => false,
            ],
        ]);
        Logger::logApiResponse($logId, $result);

        $transaction = billing_transaction_repository()->create(array_merge($transactionInformation, [
            'result'          => $result->success ? 'success' : 'failed',
            'message'         => ! $result->success ? $result->message : null,
            'billing_details' => json_encode($result),
        ]));

        if (! $result->success) {
            throw new BillingErrorException($result->message);
        }

        $order->update([
            'state'                    => 'authorized',
            'billing_provider'         => 'braintree',
            'billing_authorization_id' => $transaction->id,
        ]);

        return true;
    }

    /**
     * @param integer $orderId
     * @param float   $amount
     * @return bool
     * @throws BillingErrorException
     */
    public function settleOrder($orderId, $amount)
    {
        $order = order_repository()->find($orderId);
        if (! in_array($order->state, ['authorized', 'authorized_failed'])) {
            throw new BillingErrorException('Order not available for settlement');
        }

        $transactionInformation = [
            'order_id'            => $order->id,
            'action'              => 'settlement',
            'amount'              => $amount,
            'billing_provider'    => 'braintree',
            'billing_customer_id' => $order->billing_customer_id,
        ];

        $transactionId = null;
        try {
            $details = json_decode($order->transaction_authorize->billing_details);
            $transactionId = $details->transaction->id;
        } catch (Exception $ex) {
            throw new BillingErrorException('Unable to process transaction information.');
        }

        $logId = Logger::logApi('Braintree settleOrder', $orderId);
        $result = $this->gateway->transaction()->submitForSettlement($transactionId, $amount, [
            'orderId' => $order->id,
        ]);
        Logger::logApiResponse($logId, $result);

        $transaction = billing_transaction_repository()->create(array_merge($transactionInformation, [
            'result'          => $result->success ? 'success' : 'failed',
            'message'         => ! $result->success ? $result->message : null,
            'billing_details' => json_encode($result),
        ]));

        if (! $result->success) {
            $order->update([
                'state' => 'authorized_failed',
            ]);

            throw new BillingErrorException($result->message);
        }

        $order->update([
            'state'                 => 'success',
            'billing_settlement_id' => $transaction->id,
        ]);

        return true;
    }

    /**
     * @param integer $orderId
     * @return bool
     * @throws BillingErrorException
     * @throws NotImplementedException
     */
    public function voidOrder($orderId)
    {
        $order = order_repository()->find($orderId);
        if (! in_array($order->state, ['authorized', 'authorized_failed'])) {
            throw new BillingErrorException('Order not available for voiding');
        }

        $transactionInformation = [
            'order_id'            => $order->id,
            'action'              => 'void',
            'amount'              => $order->total,
            'billing_provider'    => 'braintree',
            'billing_customer_id' => $order->billing_customer_id,
        ];

        $transactionId = null;
        try {
            $details = json_decode($order->transaction_authorize->billing_details);
            $transactionId = $details->transaction->id;
        } catch (Exception $ex) {
            throw new BillingErrorException('Unable to process transaction information.');
        }

        $logId = Logger::logApi('Braintree refundOrder', $orderId);
        $result = $this->gateway->transaction()->void($transactionId);
        Logger::logApiResponse($logId, $result);

        $transaction = billing_transaction_repository()->create(array_merge($transactionInformation, [
            'result'          => $result->success ? 'success' : 'failed',
            'message'         => ! $result->success ? $result->message : null,
            'billing_details' => json_encode($result),
        ]));

        if (! $result->success) {
            throw new BillingErrorException($result->message);
        }

        $order->update([
            'state' => 'cancelled',
        ]);

        return true;
    }

    /**
     * @param integer $orderId
     * @return bool
     * @throws BillingErrorException
     * @throws NotImplementedException
     */
    public function refundOrder($orderId)
    {
        $order = order_repository()->find($orderId);
        if (! in_array($order->state, ['success'])) {
            throw new BillingErrorException('Order not available for refund');
        }

        $transactionInformation = [
            'order_id'            => $order->id,
            'action'              => 'refund',
            'amount'              => $order->total,
            'billing_provider'    => 'braintree',
            'billing_customer_id' => $order->billing_customer_id,
        ];

        $transactionId = null;
        try {
            $details = json_decode($order->transaction_settlement->billing_details);
            $transactionId = $details->transaction->id;
        } catch (Exception $ex) {
            throw new BillingErrorException('Unable to process transaction information.');
        }

        $logId = Logger::logApi('Braintree refundOrder', $orderId);
        $result = $this->gateway->transaction()->refund($transactionId, [
            'orderId' => $order->id,
        ]);
        Logger::logApiResponse($logId, $result);

        $transaction = billing_transaction_repository()->create(array_merge($transactionInformation, [
            'result'          => $result->success ? 'success' : 'failed',
            'message'         => ! $result->success ? $result->message : null,
            'billing_details' => json_encode($result),
        ]));

        if (! $result->success) {
            throw new BillingErrorException($result->message);
        }

        $order->update([
            'state' => 'refund',
        ]);

        return true;
    }
}