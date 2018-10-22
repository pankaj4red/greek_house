<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CampaignProductColorsRework extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->upCampaignProducts();
        $this->upCampaignLeadProducts();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->downCampaignProducts();
        $this->downCampaignLeadProducts();
    }

    public function upCampaignProducts()
    {
        Schema::rename('campaign_products', 'campaign_product_colors');
        Schema::table('campaign_product_colors', function (Blueprint $table) {
            $table->renameColumn('color_id', 'product_color_id');
        });
        Schema::table('campaign_product_colors', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }

    public function downCampaignProducts()
    {
        Schema::rename('campaign_product_colors', 'campaign_products');

        Schema::table('campaign_products', function (Blueprint $table) {
            $table->renameColumn('product_color_id', 'color_id');
        });

        Schema::table('campaign_products', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->nullable()->index()->after('campaign_id');
        });

        foreach (DB::table('campaign_products')->get() as $product) {
            DB::table('campaign_products')->where('id', $product->id)->update(['product_id' => DB::table('product_colors')->where('id', $product->color_id)->value('product_id')]);
        }
    }

    public function upCampaignLeadProducts()
    {
        Schema::table('campaign_lead_product_colors', function (Blueprint $table) {
            $table->renameColumn('color_id', 'product_color_id');
        });

        Schema::table('campaign_lead_product_colors', function (Blueprint $table) {
            $table->integer('campaign_lead_id')->unsigned()->nullable()->index()->after('id');
        });

        foreach (DB::table('campaign_lead_product_colors')->get() as $productColor) {
            DB::table('campaign_lead_product_colors')->where('id', $productColor->id)->update([
                'campaign_lead_id' => DB::table('campaign_lead_products')->where('id', $productColor->campaign_lead_product_id)->value('campaign_lead_id'),
            ]);
        }

        Schema::table('campaign_lead_product_colors', function (Blueprint $table) {
            $table->dropColumn('campaign_lead_product_id');
        });

        Schema::drop('campaign_lead_products');
    }

    public function downCampaignLeadProducts()
    {
        Schema::create('campaign_lead_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_lead_id')->unsigned()->nullable()->index();
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('campaign_lead_product_colors', function (Blueprint $table) {
            $table->renameColumn('product_color_id', 'color_id');
            $table->integer('campaign_lead_product_id')->unsigned()->nullable()->index()->after('id');
        });

        foreach (DB::table('campaign_lead_product_colors')->get() as $productColor) {
            $id = DB::table('campaign_lead_products')->insertGetId([
                'campaign_lead_id' => $productColor->campaign_lead_id,
                'product_id'       => $productColor->product_id,
                'created_at'       => $productColor->created_at,
                'updated_at'       => $productColor->updated_at,
                'deleted_at'       => $productColor->deleted_at,
            ]);

            DB::table('campaign_lead_product_colors')->where('id', $productColor->id)->update(['campaign_lead_product_id' => $id]);
        }

        Schema::table('campaign_lead_product_colors', function (Blueprint $table) {
            $table->dropColumn('campaign_lead_id');
        });
    }
}
