<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolybagAndLabelToCampaignLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_leads', function (Blueprint $table) {
            $table->boolean('polybag_and_label')->default(false)->after('source_design_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_leads', function (Blueprint $table) {
            $table->dropColumn('polybag_and_label');
        });
    }
}
