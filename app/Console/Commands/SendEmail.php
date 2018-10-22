<?php

namespace App\Console\Commands;

use App;
use App\Services\MailService;
use Illuminate\Console\Command;
use Illuminate\Queue\QueueManager;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:mail {mail} {arg}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mail = $this->argument('mail');
        $arg = $this->argument('arg');

        $queueManager = App::make(QueueManager::class);
        $queueManager->setDefaultDriver('sync');

        $mailService = App::make(MailService::class);
        $return = $mailService->$mail($arg);

        $this->output->text($return);
        $this->output->newLine();
        $this->output->text('[All Done]');

        return;
    }
}
