<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtworkFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artwork_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('artwork_id')->unsigned()->index();
            $table->integer('file_id')->unsigned()->index();
            $table->integer('sort');
            $table->string('type');
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
        Schema::drop('artwork_files');
    }
}
