<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use App\Logging\Logger;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class DeadlineReminder extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:deadline_reminder {--date=} {--campaign=} {--reset}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminders for the Deadline';

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
     * Limits the execution to only one campaign
     *
     * @var integer
     */
    protected $overrideCampaignId = null;

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
        if ($this->option('campaign')) {
            $this->overrideCampaignId = $this->option('campaign');
        }
        if ($this->option('reset')) {
            $this->overrideReset = true;
        }

        $campaigns = campaign_repository()->getPreFulfillmentNonFlexible();
        foreach ($campaigns as $campaign) {
            if ($this->overrideCampaignId && $campaign->id != $this->overrideCampaignId) {
                continue;
            }
            $reminderData = [];
            if ($this->overrideReset) {
                $campaign->reminder_deadline = serialize([]);
                $campaign->save();
            }
            if ($campaign->reminder_deadline) {
                $reminderData = unserialize($campaign->reminder_deadline);
                if (! is_array($reminderData)) {
                    $reminderData = [];
                }
                foreach ($reminderData as $key => $value) {
                    if (! is_integer($key)) {
                        $reminderData = [];
                        break;
                    }
                    if (! is_array($value)) {
                        $reminderData = [];
                        break;
                    }
                    if (! isset($value['type']) || ! is_string($value['type'])) {
                        $reminderData = [];
                        break;
                    }
                    if (! isset($value['date']) || strtotime($value['date']) == false) {
                        $reminderData = [];
                        break;
                    }
                }
            }

            $today = $this->overrideDate ?? Carbon::today()->format('Y-m-d');
            $deliveryTable = [
                0   => false,
                -1  => false,
                -2  => false,
                -3  => false,
                -4  => false,
                -5  => false,
                -6  => false,
                -7  => false,
                -8  => false,
                -9  => false,
                -10 => 'sendDeadlineFinalReminder',
                -11 => 'sendDeadlineReminder',
                -12 => false,
                -13 => 'sendDeadlineReminder',
                -14 => false,
                -15 => 'sendDeadlineReminder',
                -16 => false,
                -17 => false,
                -18 => 'sendDeadlineReminder',
                -19 => false,
                -20 => false,
                -21 => 'sendDeadlineReminder',
                -22 => false,
                -23 => false,
                -24 => 'sendDeadlineReminder',
                -25 => false,
                -26 => false,
                -27 => 'sendDeadlineReminder',
                -28 => false,
                -29 => false,
                -30 => 'sendDeadlineReminder',
            ];
            $followup = -9;
            $deliveryBusinessDaysTable = [];
            $currentDate = Carbon::parse($campaign->date)->parse('Y-m-d');
            $safety = 30;
            for ($i = 0; $i > -count($deliveryTable); $i--) {
                while (date('N', strtotime($currentDate)) > 5 && --$safety > 0) {
                    $currentDate = Carbon::parse($currentDate)->addDays(1)->parse('Y-m-d');
                }
                if ($safety <= 0) {
                    break;
                }
                $deliveryBusinessDaysTable[$i] = $currentDate;
                $currentDate = Carbon::parse($currentDate)->addDays(1)->parse('Y-m-d');
            }
            if (count($deliveryBusinessDaysTable) != count($deliveryTable)) {
                Logger::logAlert('Problem with delivery business days table', [
                    'campaign'                  => $campaign->toArray(),
                    'deliveryBusinessDaysTable' => $deliveryBusinessDaysTable,
                    'deliveryTable'             => $deliveryTable,
                    'safety'                    => $safety,
                    'currentDate'               => $currentDate,
                ]);
                $this->line('Campaign '.$campaign->id.': Error 1');

                return;
            }
            if (in_array($today, $deliveryBusinessDaysTable)) {
                $index = array_search($today, $deliveryBusinessDaysTable);
                if ($index === false) {
                    Logger::logAlert('Problem with indexing of delivery business days table', [
                        'campaign'                  => $campaign->toArray(),
                        'deliveryBusinessDaysTable' => $deliveryBusinessDaysTable,
                        'deliveryTable'             => $deliveryTable,
                        'safety'                    => $safety,
                        'currentDate'               => $currentDate,
                        'index'                     => $index,
                    ]);
                    $this->line('Campaign '.$campaign->id.': Error 2');

                    return;
                }
                if ($deliveryTable[$index] == false) {
                    // Nothing to do here.
                    $this->line('Campaign '.$campaign->id.': Nothing to do here 1');
                    continue;
                }
                // Check if not sent yet
                $found = false;
                foreach ($reminderData as $key => $value) {
                    if ($value['type'] == $deliveryTable[$index] && $value['date'] == $deliveryBusinessDaysTable[$index]) {
                        $found = true;
                    }
                }
                if ($found == true) {
                    // Nothing to do here.
                    $this->line('Campaign '.$campaign->id.': Nothing to do here 2');
                    continue;
                }

                if ($campaign->reminders == 'on') {
                    $this->info('Campaign '.$campaign->id.' - '.$campaign->name.': Sent '.$deliveryTable[$index]);
                    $this->dispatch(new SendEmailJob($deliveryTable[$index], [$campaign->id, $this->overrideDate]));

                    $reminderData[] = [
                        'type' => $deliveryTable[$index],
                        'date' => $this->overrideDate ?? Carbon::today()->format('Y-m-d'),
                    ];
                    $campaign->reminder_deadline = serialize($reminderData);
                    $campaign->save();
                } else {
                    $this->info('Campaign '.$campaign->id.' - '.$campaign->name.': skipped');
                }
            } else {
                $this->line('Campaign '.$campaign->id.': Nothing to do here 3');
            }

            if ($campaign->followup_deadline_date == null) {
                $campaign->followup_deadline_date = $deliveryBusinessDaysTable[$followup];
                $campaign->save();
            }
        }

        return;
    }
}
