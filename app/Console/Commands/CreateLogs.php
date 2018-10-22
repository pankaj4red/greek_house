<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:create_logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the log tables';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! Schema::connection('logs')->hasTable('logs')) {
            Schema::connection('logs')->create('logs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('channel');
                $table->enum('level', ['DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAl', 'ALERT', 'EMERGENCY'])->nullable();
                $table->string('message', 3072);
                $table->integer('user_id')->nullable();
                $table->string('username')->nullable();
                $table->string('ip')->nullable();
                $table->enum('notification_status', ['NEW', 'SINGLE', 'REPORTED'])->default('NEW');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::connection('logs')->hasTable('log_details')) {
            Schema::connection('logs')->create('log_details', function (Blueprint $table) {
                $table->integer('log_id')->index();
                $table->string('key', 512)->index();
                $table->text('value')->nullable();
            });
        }

        if (! Schema::connection('logs')->hasTable('revisions')) {
            Schema::connection('logs')->create('revisions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable()->index();
                $table->string('table');
                $table->integer('content_id')->unsigned();
                $table->longText('content');
                $table->longText('original')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::connection('logs')->hasTable('emails')) {
            Schema::connection('logs')->create('emails', function (Blueprint $table) {
                $table->increments('id');
                $table->string('from', 1024)->nullable();
                $table->string('to', 1024)->nullable();
                $table->string('cc', 1024)->nullable();
                $table->string('subject');
                $table->longText('body');
                $table->timestamps();
                $table->softDeletes();
            });
            if (\App::environment() !== 'testing') {
                DB::connection('logs')->statement("ALTER TABLE emails MODIFY body LONGBLOB");
            }
        }

        if (! Schema::connection('logs')->hasTable('email_attachments')) {
            Schema::connection('logs')->create('email_attachments', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('email_id')->unsigned()->index();
                $table->string('name');
                $table->binary('content')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
            if (\App::environment() !== 'testing') {
                DB::connection('logs')->statement("ALTER TABLE email_attachments MODIFY content LONGBLOB");
            }
        }

        return;
    }

    /**
     * Removes the log tables
     */
    public function rollback()
    {
        //TODO: unused?
        Schema::connection('logs')->dropIfExists('logs');
        Schema::connection('logs')->dropIfExists('log_details');
        Schema::connection('logs')->dropIfExists('revisions');
        Schema::connection('logs')->dropIfExists('emails');
        Schema::connection('logs')->dropIfExists('email_attachments');
    }
}
