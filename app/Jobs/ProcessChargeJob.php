<?php

namespace App\Jobs;

use App\Exceptions\BillingErrorException;
use App\Logging\Logger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessChargeJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $orderId;

    protected $chargeId;

    protected $amount;

    protected $logAsError;

    function __construct($orderId, $chargeId, $amount, $logAsError = true)
    {
        $this->orderId = $orderId;
        $this->chargeId = $chargeId;
        $this->amount = $amount;
        $this->logAsError = $logAsError;
    }

    public function handle()
    {
        try {
            $order = order_repository()->find($this->orderId);
            if (! in_array($order->state, ['authorized', 'authorized_failed'])) {
                return;
            }

            $billing = billing_repository($order->billing_provider);
            $billing->settleOrder($this->orderId, $this->amount);
        } catch (BillingErrorException $ex) {
            Logger::logNotice($ex->getMessage(), [
                'job'       => 'ProcessChargeJob',
                'orderId'   => $this->orderId,
                'chargeId'  => $this->chargeId,
                'amount'    => $this->amount,
                'exception' => $ex,
                'order'     => $order->toArray(),
            ]);
            $this->release(60);
        } catch (\Exception $ex) {
            Logger::logError($ex->getMessage(), [
                'job'       => 'ProcessChargeJob',
                'orderId'   => $this->orderId,
                'chargeId'  => $this->chargeId,
                'amount'    => $this->amount,
                'exception' => $ex,
            ]);
            $this->delete();
        }
    }
}
