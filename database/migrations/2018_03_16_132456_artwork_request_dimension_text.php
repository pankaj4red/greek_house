<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArtworkRequestDimensionText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artwork_requests', function (Blueprint $table) {
            $table->text('designer_colors_front_list')->nullable()->after('designer_colors_front');
            $table->text('designer_colors_back_list')->nullable()->after('designer_colors_back');
            $table->text('designer_colors_sleeve_left_list')->nullable()->after('designer_colors_sleeve_left');
            $table->text('designer_colors_sleeve_right_list')->nullable()->after('designer_colors_sleeve_right');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artwork_requests', function (Blueprint $table) {
            $table->dropColumn(['designer_colors_front_list', 'designer_colors_back_list', 'designer_colors_sleeve_left_list', 'designer_colors_sleeve_right_list']);
        });
    }
}
