<?php

namespace App\Console\Commands;

use App\Console\ConsoleOutput;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFOpportunityHandler;
use Illuminate\Console\Command;

class SalesforceIntegrationCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:sf_integration_campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs the Salesforce Campaign Data Synchronization';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        ConsoleOutput::setVerbose(true);
        ini_set('memory_limit', '2G');
        ConsoleOutput::setConsoleOutput($this->output);

        ConsoleOutput::title('Command: Salesforce Integration');
        if (! config('services.salesforce.enabled')) {
            ConsoleOutput::error('Salesforce Integration Disabled', \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);
            Logger::logError('Salesforce Integration Disabled');

            return;
        }

        /**
         * Authenticating Salesforce
         */
        ConsoleOutput::info('Authenticating Salesforce...', \App\Console\CO_TIMESTAMP);
        $salesforce = SalesforceRepositoryFactory::get();
        ConsoleOutput::success('[Done]', \App\Console\CO_LINE_BREAK);

        /**
         * Synchronizing Campaigns
         */
        $opportunities = $salesforce->opportunity()->getOpportunitiesFromDate(config('services.salesforce.cutout_date'));
        (new SFOpportunityHandler())->handle($opportunities);

        return;
    }
}
