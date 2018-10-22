<?php

namespace App\Repositories\Billing;

use App\Contracts\Billing\BillingRepository;
use App\Exceptions\BillingErrorException;
use App\Exceptions\NotImplementedException;

class TestRepository implements BillingRepository
{
    /**
     * Returns a customer id
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $phone
     * @return string
     * @throws BillingErrorException
     * @throws NotImplementedException
     */
    public function createCustomer($firstName, $lastName, $email, $phone)
    {
        return 'test';
    }

    /**
     * @param string|null $customerId
     * @return string
     * @throws NotImplementedException
     */
    public function getClientToken($customerId = null)
    {
        return 'test';
    }

    /**
     * @param string $customerId
     * @param string $nonce
     * @return string
     * @throws NotImplementedException
     */
    public function addPaymentMethod($customerId, $nonce)
    {
        return true;
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
        order_repository()->find($orderId)->update([
            'state' => 'authorized',
        ]);

        return true;
    }

    /**
     * @param integer $orderId
     * @param float   $amount
     * @return bool
     * @throws BillingErrorException
     * @throws NotImplementedException
     */
    public function settleOrder($orderId, $amount)
    {
        order_repository()->find($orderId)->update([
            'state' => 'success',
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
        order_repository()->find($orderId)->update([
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
        return true;
    }
}
