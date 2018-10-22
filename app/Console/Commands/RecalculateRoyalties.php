<?php

namespace App\Console\Commands;

use App\Console\ConsoleOutput;
use Illuminate\Console\Command;

class RecalculateRoyalties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:recalculate_royalties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculates Royalty values';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ConsoleOutput::setConsoleOutput($this->output);
        ConsoleOutput::title('Command: Recalculating Royalty values');

        foreach (campaign_repository()->all() as $campaign) {
            if (in_array($campaign->state, [
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
            ])) {
                ConsoleOutput::comment($campaign->id.' - '.$campaign->name, App\Console\CO_LINE_BREAK | App\Console\CO_TIMESTAMP);
                $campaign->calculateRoyaltiesAndCommissions();
            }
        }

        return 'ok';
    }
}
