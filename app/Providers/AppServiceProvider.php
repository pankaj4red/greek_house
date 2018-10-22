<?php

namespace App\Providers;

use App\Repositories\Salesforce\SalesforceApi;
use App\Repositories\Salesforce\SalesforceRepository;
use App\Validators\DateYear;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.protocol')) {
            URL::forceScheme(config('app.protocol'));
        }

        Validator::extend(DateYear::$rule, DateYear::class.'@validate');

        Validator::extend('same_size', function ($attribute, $value, $parameters, $validator) {
            return count($value) == count($validator->getData()[$parameters[0]]);
        }, 'The :attribute does not match size');

        Validator::extend('phone', function ($attribute, $value) {
            return strlen(get_phone_digits($value)) == 10;
        }, 'Contact Phone needs 10 digits');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('salesforce.live', function () {
            return new SalesforceRepository(new SalesforceApi('live', config('services.salesforce.live.login_url'), config('services.salesforce.live.consumer_key'), config('services.salesforce.live.consumer_secret'), config('services.salesforce.live.token')));
        });

        $this->app->bind('salesforce.sandbox', function () {
            return new SalesforceRepository(new SalesforceApi('sandbox', config('services.salesforce.sandbox.login_url'), config('services.salesforce.sandbox.consumer_key'), config('services.salesforce.sandbox.consumer_secret'), config('services.salesforce.sandbox.token')));
        });

        $this->app->singleton(\App\Repositories\Billing\BrainTreeRepository::class, function () {
            return new \App\Repositories\Billing\BrainTreeRepository();
        });
    }
}
