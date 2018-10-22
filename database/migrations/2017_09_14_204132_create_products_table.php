<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku');
            $table->string('name');
            $table->integer('garment_category_id')->unsigned()->nullable()->index();
            $table->integer('garment_gender_id')->unsigned()->nullable()->index();
            $table->integer('garment_brand_id')->unsigned()->nullable()->index();
            $table->string('description', 1024);
            $table->string('sizes_text', 1024);
            $table->string('style_number');
            $table->string('features', 1024);
            $table->decimal('price');
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
        Schema::drop('products');
    }
}
