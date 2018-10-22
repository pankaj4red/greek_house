<?php

namespace App\Console\Commands;

use App\Console\ConsoleOutput;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFLeadManager;
use Illuminate\Console\Command;

class SalesforceIntegrationLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:sf_integration_leads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs the Salesforce Lead auto-close';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        ConsoleOutput::setVerbose(true);
        ConsoleOutput::setConsoleOutput($this->output);

        ConsoleOutput::title('Command: Salesforce Leads');
        if (! config('services.salesforce.enabled')) {
            ConsoleOutput::error('Salesforce Leads Disabled', \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);
            Logger::logError('Salesforce Leads Disabled');

            return;
        }

        /**
         * Authenticating Salesforce
         */
        ConsoleOutput::info('Authenticating Salesforce...', \App\Console\CO_TIMESTAMP);
        $salesforce = SalesforceRepositoryFactory::get();
        ConsoleOutput::success('[Done]', \App\Console\CO_LINE_BREAK);

        /**
         * Synchronizing Leads
         */
        $leads = $salesforce->lead()->getLeads();
        $leadManager = new SFLeadManager($leads);
        $leadManager->process();
        $toSave = $leadManager->getToSave();
        $salesforce->lead()->setLeadsStatus($toSave);

        return;
    }
}
