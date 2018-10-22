<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class DeadlineFollowUp extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:deadline_followup {--date=} {--campaign=} {--reset}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Follow up report for the Deadline';

    /**
     * Overrides the current date (for testing)
     *
     * @var string
     */
    protected $overrideDate = null;

    /**
     * Resets the notification cycle (for testing)
     *
     * @var bool
     */
    protected $overrideReset = false;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('date')) {
            $this->overrideDate = Carbon::parse($this->option('date'))->format('Y-m-d');
        }
        if ($this->option('reset')) {
            $this->overrideReset = true;
        }
        if ($this->overrideReset) {
            DB::update('UPDATE campaigns SET followup_deadline = NULL');
        }

        $date = $this->overrideDate ?? Carbon::today()->format('Y-m-d');
        $campaigns = campaign_repository()->getAwaitingDeadlineFollowUp($date);
        foreach ($campaigns as $campaign) {
            $campaign->followup_deadline = 'yes';
            $campaign->save();
        }

        $this->dispatch(new SendEmailJob('sendDeadlineReminderFollowUp', []));

        return;
    }
}
