<?php

namespace App\Console\Commands;

use Config;
use Illuminate\Console\Command;
use Queue;

class QueueList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:list {queue} {page} {pageSize}';

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
        $page = $this->hasArgument('page') ? $this->argument('page') : 0;
        $pageSize = $this->hasArgument('pageSize') ? $this->argument('pageSize') : 20;
        $queue = ($this->hasArgument('queue') && $this->argument('queue')) ? $this->argument('queue') : null;

        if (config('queue.default') == 'beanstalkd') {
            $queue = $queue ?? Config::get('queue.connections.beanstalkd.queue');
            $this->info(sprintf('Listing queue: %s', $queue));
            $pheanstalk = Queue::getPheanstalk();
            $pheanstalk->useTube($queue);
            $pheanstalk->watch($queue);

            $count = 0;
            while ($job = $pheanstalk->reserve(0)) {
                if ($count >= $page * $pageSize && $page < ($page + 1) * $pageSize) {
                    dd($pheanstalk->peekReady('default'));
                }
                $count++;
            }

            $this->info('Total: '.$count);
        }

        return;
    }
}
