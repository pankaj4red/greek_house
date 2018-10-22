<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('billing_authorization_id')->unsigned()->nullable()->index()->after('billing_provider');
            $table->integer('billing_settlement_id')->unsigned()->nullable()->index()->after('billing_authorization_id');
            $table->integer('billing_void_id')->unsigned()->nullable()->index()->after('billing_settlement_id');
            $table->integer('billing_refund_id')->unsigned()->nullable()->index()->after('billing_void_id');
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
            $table->dropColumn([
                'billing_authorization_id',
                'billing_settlement_id',
                'billing_void_id',
                'billing_refund_id',
            ]);
        });
    }
}
