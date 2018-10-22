<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizesCollectedFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->enum('payment_date_type', ['normal', 'urgent'])->default('normal')->after('fulfillment_notes');
            $table->dateTime('sizes_collected_date')->nullable()->after('payment_date_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['payment_date_type', 'sizes_collected_date']);
        });
    }
}
