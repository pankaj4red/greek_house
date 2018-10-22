<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MultipleQuotesForMultipleProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned()->nullable()->index();
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->decimal('quote_low')->nullable();
            $table->decimal('quote_high')->nullable();
            $table->decimal('quote_final')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('insert into campaign_quotes (campaign_id, product_id, quote_low, quote_high, quote_final) select distinct campaigns.id, product_colors.product_id, campaigns.quote_low, campaigns.quote_high, campaigns.quote_final from campaigns inner join campaign_product_colors inner join product_colors on product_colors.id = campaign_product_colors.product_color_id where campaigns.id = campaign_product_colors.campaign_id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_quotes');
    }
}
