<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllowAdditionalToGarmentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garment_categories', function (Blueprint $table) {
            $table->boolean('allow_additional')->default(true)->after('wizard');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garment_categories', function (Blueprint $table) {
            $table->dropColumn('allow_additional');
        });
    }
}
