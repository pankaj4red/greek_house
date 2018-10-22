<?php

namespace App\Repositories\Billing;

use App\Contracts\Billing\BillingRepository;
use App\Exceptions\BillingErrorException;
use App\Exceptions\NotImplementedException;

class ManualRepository implements BillingRepository
{
    /**
     * Returns a customer id
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $phone
     * @return string
     */
    public function createCustomer($firstName, $lastName, $email, $phone)
    {

    }

    /**
     * @param string $customerId
     * @return string
     */
    public function getClientToken($customerId = null)
    {
        return null;
    }

    /**
     * @param string $customerId
     * @param string $nonce
     * @return string
     */
    public function addPaymentMethod($customerId, $nonce)
    {
        return null;
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

        $order->update([
            'state'            => 'authorized',
            'billing_provider' => 'manual',
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
        $order->updateMetadata();
        if (! in_array($order->state, ['authorized', 'authorized_failed'])) {
            throw new BillingErrorException('Order not available for settlement');
        }

        $order->update([
            'state'            => 'success',
            'billing_provider' => 'manual',
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

        $order->update([
            'state'            => 'cancelled',
            'billing_provider' => 'manual',
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
            throw new BillingErrorException('Order not available for voiding');
        }

        $order->update([
            'state'            => 'refund',
            'billing_provider' => 'manual',
        ]);

        return true;
    }
}