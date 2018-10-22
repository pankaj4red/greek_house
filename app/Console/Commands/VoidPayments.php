<?php

namespace App\Console\Commands;

use App\Jobs\VoidChargeJob;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class VoidPayments extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:void_payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Voids Payments on Cancelled Campaigns';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $orders = order_repository()->getCancellingOrders();
            foreach ($orders as $order) {
                $this->dispatch(new VoidChargeJob($order->id, $order->billing_charge_id));
            }

            $orders = order_repository()->getCancellingExpiredOrders();
            foreach ($orders as $order) {
                $order->state = 'cancelled';
                $order->save();
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        return;
    }
}
