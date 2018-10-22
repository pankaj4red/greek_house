<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArtworkRequestDesignColors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artwork_requests', function (Blueprint $table) {
            $table->string('designer_dimensions_front')->nullable()->after('designer_colors_front');
            $table->string('designer_dimensions_back')->nullable()->after('designer_colors_back');
            $table->string('designer_dimensions_sleeve_left')->nullable()->after('designer_colors_sleeve_left');
            $table->string('designer_dimensions_sleeve_right')->nullable()->after('designer_colors_sleeve_right');
        });
        Schema::table('artworks', function (Blueprint $table) {
            $table->string('designer_dimensions_front')->nullable()->after('designer_colors_front');
            $table->string('designer_dimensions_back')->nullable()->after('designer_colors_back');
            $table->string('designer_dimensions_sleeve_left')->nullable()->after('designer_colors_sleeve_left');
            $table->string('designer_dimensions_sleeve_right')->nullable()->after('designer_colors_sleeve_right');
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
            $table->dropColumn(['designer_dimensions_front', 'designer_dimensions_back', 'designer_dimensions_sleeve_left', 'designer_dimensions_sleeve_right']);
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn(['designer_dimensions_front', 'designer_dimensions_back', 'designer_dimensions_sleeve_left', 'designer_dimensions_sleeve_right']);
        });
    }
}
