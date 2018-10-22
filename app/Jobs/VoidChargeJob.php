<?php

namespace App\Jobs;

use App\Exceptions\BillingErrorException;
use App\Logging\Logger;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VoidChargeJob extends Job
{
    use InteractsWithQueue, SerializesModels;

    protected $orderId;

    protected $chargeId;

    function __construct($orderId, $chargeId)
    {
        $this->orderId = $orderId;
        $this->chargeId = $chargeId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $order = order_repository()->find($this->orderId);
            if (! in_array($order->state, ['authorized', 'authorized_failed'])) {
                return;
            }

            $billing = billing_repository($order->billing_provider);
            $billing->voidOrder($this->orderId);
        } catch (BillingErrorException $ex) {
            Logger::logNotice($ex->getMessage(), [
                'job'       => 'VoidChargeJob',
                'orderId'   => $this->orderId,
                'chargeId'  => $this->chargeId,
                'exception' => $ex,
                'order'     => $order->toArray(),
            ]);
            $this->release(60);
        } catch (\Exception $ex) {
            Logger::logError($ex->getMessage(), [
                'job'       => 'VoidChargeJob',
                'orderId'   => $this->orderId,
                'chargeId'  => $this->chargeId,
                'exception' => $ex,
            ]);
            $this->delete();
        }
    }
}
