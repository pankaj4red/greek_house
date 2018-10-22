<?php

namespace App\Console\Commands;

use App\Events\Campaign\FulfillmentReady;
use App\Events\Campaign\PaymentProcessed;
use App\Jobs\ProcessChargeJob;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Queue;

class ProcessPayments extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:process_payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes pending authorized payments';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            Queue::setDefaultDriver('sync');

            $count = 0;
            $this->info('Processing Failed Orders:');
            $campaigns = campaign_repository()->getExpiredProcessingPayment();

            foreach ($campaigns as $campaign) {
                $campaign->state = 'fulfillment_ready';
                $campaign->save();

                event(new PaymentProcessed($campaign->id, 'timeout'));
                event(new FulfillmentReady($campaign->id));

                foreach ($campaign->authorized_orders as $order) {
                    if (in_array($order->state, ['authorized', 'authorized_failed'])) {
                        $order->state = 'authorized_failed';
                        $order->save();
                        $this->comment((++$count).',"failed",'.$campaign->id.',"'.$campaign->name.'",'.$order->id.','.Carbon::now()->diffInDays(Carbon::createFromTimestamp(strtotime($order->created_at))));
                    }
                }
            }

            $count = 0;
            $this->line('');
            $this->info('Processing Failed Orders:');
            $campaigns = campaign_repository()->getCurrentlyProcessingPayment();
            foreach ($campaigns as $campaign) {

                if ($campaign->processed_at == '0000-00-00 00:00:00') {
                    continue;
                }

                $unprocessedOrders = false;
                foreach ($campaign->authorized_orders as $order) {
                    if (in_array($order->state, ['authorized', 'authorized_failed'])) {
                        $this->comment((++$count).',"processing",'.$campaign->id.',"'.$campaign->name.'",'.$order->id.','.Carbon::now()->diffInDays(Carbon::createFromTimestamp(strtotime($order->created_at))));
                        $this->dispatch(new ProcessChargeJob($order->id, $order->billing_charge_id, $order->total));
                        $unprocessedOrders = true;
                    }
                }

                if ($unprocessedOrders == false) {
                    $campaign->state = 'fulfillment_ready';
                    $campaign->save();

                    event(new PaymentProcessed($campaign->id, 'ok'));
                    event(new FulfillmentReady($campaign->id));
                }
            }

            $count = 0;
            $campaigns = campaign_repository()->getInState('collecting_payment');
            $this->line('');
            $this->info('Expiring Orders:');
            foreach ($campaigns as $campaign) {
                /* @var Campaign $campaign */
                foreach ($campaign->expiring_orders as $order) {
                    $this->comment((++$count).','.$campaign->id.',"'.$campaign->name.'",'.$order->id.','.Carbon::now()->diffInDays(Carbon::createFromTimestamp(strtotime($order->created_at))));
                    $this->dispatch(new ProcessChargeJob($order->id, $order->billing_charge_id, $order->total, false));
                }
            }

            $count = 0;
            $campaigns = campaign_repository()->getInState('collecting_payment');
            $this->line('');
            $this->info('Expired Orders:');
            foreach ($campaigns as $campaign) {
                foreach ($campaign->expired_orders() as $order) {
                    $this->comment((++$count).','.$campaign->id.',"'.$campaign->name.'",'.$order->id.','.Carbon::now()->diffInDays(Carbon::createFromTimestamp(strtotime($order->created_at))));
                }
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        return;
    }
}
