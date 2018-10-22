<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignCloseDate extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:campaigns_close_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handles the close date of open campaigns (Cronjob)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $campaigns = campaign_repository()->getPaymentClosingIn24h();
            foreach ($campaigns as $campaign) {
                $campaign->flagClosingIn24HoursEmailSent();
                $campaign->notificationClosingIn24Hours();
            }

            $campaigns = campaign_repository()->getNeedsPaymentClosing();
            foreach ($campaigns as $campaign) {
                $notificationType = $campaign->closePayment();
                $campaign->notificationClosePayment($notificationType);
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        return;
    }
}
