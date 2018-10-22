<?php

namespace App\Console\Commands;

use Config;
use Illuminate\Console\Command;
use Queue;

class QueueClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear a Beanstalkd queue, by deleting all pending jobs.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $queue = ($this->hasArgument('queue') && $this->argument('queue')) ? $this->argument('queue') : null;

        if (config('queue.default') == 'beanstalkd') {
            $queue = $queue ?? Config::get('queue.connections.beanstalkd.queue');
            $this->info(sprintf('Clearing queue: %s', $queue));
            $pheanstalk = Queue::getPheanstalk();
            $pheanstalk->useTube($queue);
            $pheanstalk->watch($queue);

            $count = 0;
            while ($job = $pheanstalk->reserve(0)) {
                $this->getOutput()->write('.');
                $count++;
                $pheanstalk->delete($job);
            }

            $this->info($count.' cleared.');
        }

        return;
    }
}
