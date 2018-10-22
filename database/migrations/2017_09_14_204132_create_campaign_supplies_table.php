<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCampaignSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_supplies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned()->nullable()->index();
            $table->integer('supplier_id')->unsigned()->nullable()->index();
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->integer('color_id')->unsigned()->nullable()->index();
            $table->string('ship_from');
            $table->string('eta');
            $table->integer('quantity');
            $table->decimal('total');
            $table->enum('state', ['new', 'ordered', 'shipped', 'arrived', 'completed', 'nok', 'cancelled'])->default('new');
            $table->text('nok_reason', 65535)->nullable();
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
        Schema::drop('campaign_supplies');
    }
}
