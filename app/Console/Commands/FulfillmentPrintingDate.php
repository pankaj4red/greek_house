<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FulfillmentPrintingDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:printing_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Moves expired fulfillment validation\'s campaigns to the printing state';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $campaigns = campaign_repository()->getExpiredPrintingDate();

        foreach ($campaigns as $campaign) {
            $campaign->update([
                'state' => 'printing',
            ]);
        }

        return;
    }
}
