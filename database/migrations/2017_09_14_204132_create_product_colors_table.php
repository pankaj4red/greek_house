<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->string('name');
            $table->integer('thumbnail_id')->unsigned()->nullable()->index();
            $table->integer('image_id')->unsigned()->nullable()->index();
            $table->boolean('active')->default(1);
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
        Schema::drop('product_colors');
    }
}
