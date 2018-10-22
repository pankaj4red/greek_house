<?php

namespace App\Contracts\Billing;

use App\Exceptions\BillingErrorException;
use App\Exceptions\NotImplementedException;

interface BillingRepository
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
    public function createCustomer($firstName, $lastName, $email, $phone);

    /**
     * @param string|null $customerId
     * @return string
     * @throws NotImplementedException
     */
    public function getClientToken($customerId = null);

    /**
     * @param string $customerId
     * @param string $nonce
     * @return string
     * @throws NotImplementedException
     */
    public function addPaymentMethod($customerId, $nonce);

    /**
     * @param string  $customerId
     * @param string  $paymentMethod
     * @param integer $orderId
     * @return bool
     * @throws NotImplementedException
     */
    public function authorizeOrder($customerId, $paymentMethod, $orderId);

    /**
     * @param integer $orderId
     * @param float   $amount
     * @return bool
     * @throws BillingErrorException
     * @throws NotImplementedException
     */
    public function settleOrder($orderId, $amount);

    /**
     * @param integer $orderId
     * @return bool
     * @throws BillingErrorException
     * @throws NotImplementedException
     */
    public function voidOrder($orderId);

    /**
     * @param integer $orderId
     * @return bool
     * @throws BillingErrorException
     * @throws NotImplementedException
     */
    public function refundOrder($orderId);
}
