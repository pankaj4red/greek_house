<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGarmentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garment_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('image_id')->unsigned()->nullable()->index();
            $table->boolean('active')->default(1);
            $table->integer('sort')->default(0);
            $table->enum('wizard', ['show', 'default', 'hide'])->default('show');
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
        Schema::drop('garment_categories');
    }
}
