<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('design_type')->default('screen');
            $table->boolean('designer_black_shirt')->default(0);
            $table->enum('speciality_inks', ['yes', 'no'])->default('no');
            $table->enum('embellishment_names', ['yes', 'no'])->default('no');
            $table->enum('embellishment_numbers', ['yes', 'no'])->default('no');
            $table->integer('designer_colors_front')->default(0);
            $table->integer('designer_colors_back')->default(0);
            $table->integer('designer_colors_sleeve_left')->default(0);
            $table->integer('designer_colors_sleeve_right')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('artworks');
    }
}
