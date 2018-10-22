<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCampaignSupplyEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_supply_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_supply_id')->unsigned()->index();
            $table->integer('garment_size_id')->unsigned()->index();
            $table->integer('quantity');
            $table->decimal('price');
            $table->decimal('subtotal');
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
        Schema::drop('campaign_supply_entries');
    }
}
