<?php

namespace App\Console;

use App\Console\Commands\AwaitingApprovalFollowUp;
use App\Console\Commands\AwaitingApprovalReminder;
use App\Console\Commands\CacheImages;
use App\Console\Commands\CampaignCloseDate;
use App\Console\Commands\CollectingPaymentFollowUp;
use App\Console\Commands\CollectingPaymentReminder;
use App\Console\Commands\CreateLogs;
use App\Console\Commands\DeadlineFollowUp;
use App\Console\Commands\DeadlineReminder;
use App\Console\Commands\FulfillmentMarkShipped;
use App\Console\Commands\FulfillmentPrintingDate;
use App\Console\Commands\IntegrityCheck;
use App\Console\Commands\NoOrdersFollowUp;
use App\Console\Commands\ProcessPayments;
use App\Console\Commands\QueueClear;
use App\Console\Commands\QueueList;
use App\Console\Commands\RecalculateRoyalties;
use App\Console\Commands\SalesforceIntegrationCampaigns;
use App\Console\Commands\SalesforceIntegrationContacts;
use App\Console\Commands\SalesforceIntegrationLeads;
use App\Console\Commands\SendEmail;
use App\Console\Commands\VoidPayments;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'gh:campaigns_close_date'                                          => CampaignCloseDate::class,
        'gh:process_payments'                                              => ProcessPayments::class,
        'gh:void_payments'                                                 => VoidPayments::class,
        'gh:mark_shipped'                                                  => FulfillmentMarkShipped::class,
        'gh:awaiting_approval_reminder {--date=} {--campaign=} {--reset}'  => AwaitingApprovalReminder::class,
        'gh:collecting_payment_followup {--date=} {--campaign=} {--reset}' => CollectingPaymentReminder::class,
        'gh:deadline_reminder {--date=} {--campaign=} {--reset}'           => DeadlineReminder::class,
        'gh:awaiting_approval_followup {--date=} {--campaign=} {--reset}'  => AwaitingApprovalFollowUp::class,
        'gh:collecting_payment_reminder {--date=} {--campaign=} {--reset}' => CollectingPaymentFollowUp::class,
        'gh:deadline_followup {--date=} {--campaign=} {--reset}'           => DeadlineFollowUp::class,
        'gh:no_orders_followup {--date=} {--campaign=} {--reset}'          => NoOrdersFollowUp::class,
        'gh:sf_integration_contacts'                                       => SalesforceIntegrationContacts::class,
        'gh:sf_integration_campaigns'                                      => SalesforceIntegrationCampaigns::class,
        'gh:sf_integration_leads'                                          => SalesforceIntegrationLeads::class,
        'gh:printing_date'                                                 => FulfillmentPrintingDate::class,
        'gh:recalculate_royalties'                                         => RecalculateRoyalties::class,
        'gh:create_logs'                                                   => CreateLogs::class,
        'gh:mail {mail} {arg}'                                             => SendEmail::class,
        'gh:integrity_check {--fix}'                                       => IntegrityCheck::class,
        'queue:clear'                                                      => QueueClear::class,
        'queue:list {queue} {page} {pageSize}'                             => QueueList::class,
        'gh:cache_images'                                                  => CacheImages::class,
        'gh:transfer_campaign {id} {from} {to}'                            => CacheImages::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /** Reminders and follow ups */

        $schedule->command('gh:awaiting_approval_reminder')->dailyAt('12:01')->thenPing(config('heartbeat.awaiting_approval_reminder'))->sendOutputTo(tmp_path('awaiting_approval_reminder'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('awaiting_approval_reminder');

        $schedule->command('gh:awaiting_approval_followup')->dailyAt('12:02')->thenPing(config('heartbeat.awaiting_approval_follow_up'))->sendOutputTo(tmp_path('awaiting_approval_follow_up'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('awaiting_approval_follow_up');

        $schedule->command('gh:collecting_payment_reminder')->dailyAt('12:03')->thenPing(config('heartbeat.collecting_payment_reminder'))->sendOutputTo(tmp_path('collecting_payment_reminder'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('collecting_payment_reminder');

        $schedule->command('gh:collecting_payment_followup')->dailyAt('12:04')->thenPing(config('heartbeat.collecting_payment_follow_up'))->sendOutputTo(tmp_path('collecting_payment_follow_up'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('collecting_payment_follow_up');

        $schedule->command('gh:deadline_reminder')->dailyAt('12:05')->thenPing(config('heartbeat.deadline_reminder'))->sendOutputTo(tmp_path('deadline_reminder'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('deadline_reminder');

        $schedule->command('gh:deadline_followup')->dailyAt('12:06')->thenPing(config('heartbeat.deadline_follow_up'))->sendOutputTo(tmp_path('deadline_follow_up'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('deadline_follow_up');

        $schedule->command('gh:no_orders_followup')->dailyAt('12:07')->thenPing(config('heartbeat.no_orders_follow_up'))->sendOutputTo(tmp_path('no_orders_follow_up'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('no_orders_follow_up');

        /** Salesforce */

        $schedule->command('gh:sf_integration_accounts')->dailyAt('09:00')->thenPing(config('heartbeat.sf_accounts'))->sendOutputTo(tmp_path('sf_accounts'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('sf_integration_accounts');

        $schedule->command('gh:sf_integration_leads')->everyFiveMinutes()->thenPing(config('heartbeat.sf_leads'))->sendOutputTo(tmp_path('sf_leads'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('sf_leads');

        $schedule->command('gh:process_payments')->everyFiveMinutes()->thenPing(config('heartbeat.process_payments'))->sendOutputTo(tmp_path('process_payments'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('process_payments');

        $schedule->command('gh:void_payments')->everyFiveMinutes()->thenPing(config('heartbeat.void_payments'))->sendOutputTo(tmp_path('void_payments'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('void_payments');

        $schedule->command('gh:sf_integration_campaigns')->cron('0,20,40 * * * *')->thenPing(config('heartbeat.sf_campaigns'))->sendOutputTo(tmp_path('sf_campaigns'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('sf_integration_campaigns');

        $schedule->command('gh:sf_integration_contacts')->cron('10,30,50 * * * *')->thenPing(config('heartbeat.sf_contacts'))->sendOutputTo(tmp_path('sf_contacts'))->emailOutputTo(config('notifications.mail.schedule_log.email'))->description('sf_integration_contacts');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
