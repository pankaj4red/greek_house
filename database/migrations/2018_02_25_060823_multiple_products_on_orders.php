<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MultipleProductsOnOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_entries', function (Blueprint $table) {
            $table->integer('product_color_id')->unsigned()->nullable()->index()->after('garment_size_id');
        });

        if (App::environment() != 'testing') {
            DB::update('update order_entries inner join orders on orders.id = order_entries.order_id set order_entries.product_color_id = orders.color_id');
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'color_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->nullable()->index()->after('campaign_id');
            $table->integer('color_id')->unsigned()->nullable()->index()->after('product_id');
        });

        DB::update('update orders inner join order_entries on orders.id = order_entries.order_id set orders.color_id = order_entries.product_color_id');
        DB::update('update orders inner join product_colors on orders.product_color_id = product_colors.id set orders.product_id = order_entries.product_color_id');

        Schema::table('order_entries', function (Blueprint $table) {
            $table->dropColumn('product_color_id');
        });
    }
}
