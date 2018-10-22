<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDesignFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('design_id')->unsigned()->nullable()->index('design_id');
            $table->integer('file_id')->unsigned()->nullable()->index();
            $table->string('type');
            $table->boolean('enabled')->default(1);
            $table->integer('sort')->default(0);
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
        Schema::drop('design_files');
    }
}
