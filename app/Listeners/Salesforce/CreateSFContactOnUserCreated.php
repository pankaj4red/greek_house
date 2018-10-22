<?php

namespace App\Listeners\Salesforce;

use App\Events\User\UserCreated;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFContact;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CreateSFContactOnUserCreated
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        if (config('services.salesforce.enabled')) {
            try {
                $user = user_repository()->find($event->userId);
                if ($user->sf_id) {
                    Logger::logDebug('#CreateSFContactOnUserCreated '.$event->userId.' already associated on #Salesforce');

                    return;
                }
                $contact = SFContact::createFromUser($user);

                $repository = SalesforceRepositoryFactory::get();
                $contact = $repository->contact()->putContact($contact);

                $user->update([
                    'sf_id' => $contact->Id,
                ]);

                Logger::logDebug('#CreateSFContactOnUserCreated '.$event->userId.' information sent to #Salesforce');
            } catch (\Exception $exception) {
                Logger::logError('#CreateSFContactOnUserCreated SF: '.$exception->getMessage(), ['exception' => $exception]);
            }
        } else {
            Logger::logDebug('#CreateSFContactOnUserCreated '.$event->userId.' information sent [SKIPPED] to #Salesforce');
        }
    }
}