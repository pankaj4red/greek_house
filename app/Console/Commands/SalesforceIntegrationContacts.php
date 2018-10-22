<?php

namespace App\Console\Commands;

use App\Console\ConsoleOutput;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFContactFromLeadManager;
use App\Salesforce\SFContactManager;
use Illuminate\Console\Command;

class SalesforceIntegrationContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:sf_integration_contacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs the Salesforce Contact Data Synchronization';

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
         * Synchronizing Contacts (From Leads)
         */
        ConsoleOutput::info('Synchronizing Contacts From Leads...', \App\Console\CO_TIMESTAMP);
        $leads = $salesforce->lead()->getLeads();
        $contacts = $salesforce->contact()->getContacts();
        $contactManager = new SFContactFromLeadManager($contacts);
        $contactManager->setLeadFields($leads);
        $toSave = $contactManager->toSave();
        $salesforce->contact()->putContacts($toSave);

        /**
         * Synchronizing Users
         */
        $contacts = $salesforce->contact()->getContacts();
        $contactManager = new SFContactManager($contacts);
        $contactManager->process();
        $toSave = $contactManager->getToSave();
        $salesforce->contact()->putContacts($toSave);
        $contactManager->saveInDatabase();
        $contactManager->associateInDatabase();
        $contactManager->saveLog();

        return;
    }
}
