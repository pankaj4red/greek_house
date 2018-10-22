<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class FulfillmentMarkShipped extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:mark_shipped';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handles the "mark shipped" email (Cronjob)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $campaigns = campaign_repository()->getExpiredPrintings();
            foreach ($campaigns as $campaign) {
                $this->dispatch(new SendEmailJob('fulfillmentMarkShipped', [$campaign->id]));
                $this->info('Campaign Mark Shipped Email sent to ['.$campaign->id.'] '.$campaign->name);
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        return;
    }
}
