<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('suggested_supplier')->nullable()->after('image_id');
            $table->text('designer_instructions')->nullable()->after('suggested_supplier');
            $table->text('fulfillment_instructions')->nullable()->after('designer_instructions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('suggested_supplier');
            $table->dropColumn('designer_instructions');
            $table->dropColumn('fulfillment_instructions');
        });
    }
}
