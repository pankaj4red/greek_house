<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('internal_filename')->nullable();
            $table->integer('size')->default(0);
            $table->string('type')->default('file');
            $table->string('sub_type')->default('unknown');
            $table->string('mime_type')->default('unknown');
            $table->integer('image_id')->unsigned()->nullable();
            $table->integer('content_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }
}
