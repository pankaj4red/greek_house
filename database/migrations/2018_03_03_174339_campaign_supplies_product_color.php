<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CampaignSuppliesProductColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_supplies', function (Blueprint $table) {
            $table->integer('product_color_id')->unsigned()->nullable()->index()->after('product_id');
        });

        if (App::environment() != 'testing') {
            DB::update('update campaign_supplies inner join campaign_product_colors on campaign_supplies.campaign_id = campaign_product_colors.campaign_id inner join product_colors on product_colors.product_id = campaign_supplies.product_id set campaign_supplies.product_color_id = product_colors.id');
        }

        Schema::table('campaign_supplies', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_supplies', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->nullable()->index()->after('product_color_id');
        });

        if (App::environment() != 'testing') {
            DB::update('update campaign_supplies inner join product_colors on product_colors.id = campaign_supplies.product_color_id set campaign_supplies.product_id = product_colors.product_id');
        }

        Schema::table('campaign_supplies', function (Blueprint $table) {
            $table->dropColumn('product_color_id');
        });
    }
}
