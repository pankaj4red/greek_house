<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtworkRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artwork_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('designer_id')->unsigned()->nullable()->index();
            $table->enum('state', ['on_hold', 'awaiting_design', 'awaiting_approval', 'revision_requested', 'approved', 'cancelled'])->default('awaiting_design');
            $table->integer('revision_count')->default(0);
            $table->string('revision_text', 2048)->nullable();
            $table->boolean('print_front')->default(0);
            $table->string('print_front_colors')->nullable();
            $table->text('print_front_description', 65535)->nullable();
            $table->boolean('print_pocket')->default(0);
            $table->string('print_pocket_colors')->nullable();
            $table->text('print_pocket_description', 65535)->nullable();
            $table->boolean('print_back')->default(0);
            $table->string('print_back_colors')->nullable();
            $table->text('print_back_description', 65535)->nullable();
            $table->boolean('print_sleeve')->default(0);
            $table->string('print_sleeve_colors')->nullable();
            $table->string('print_sleeve_preferred')->nullable();
            $table->text('print_sleeve_description', 65535)->nullable();
            $table->enum('design_style_preference', ['none', 'cartoon', 'realistic_sketch', 'mixed_graphic', 'line_art', 'typographical', 'graphic_stamp'])->default('none');
            $table->string('design_type')->default('screen');
            $table->integer('design_minutes')->default(0);
            $table->decimal('hourly_rate')->nullable();
            $table->boolean('designer_black_shirt')->default(0);
            $table->enum('speciality_inks', ['yes', 'no'])->default('no');
            $table->enum('embellishment_names', ['yes', 'no'])->default('no');
            $table->enum('embellishment_numbers', ['yes', 'no'])->default('no');
            $table->integer('designer_colors_front')->default(0);
            $table->integer('designer_colors_back')->default(0);
            $table->integer('designer_colors_sleeve_left')->default(0);
            $table->integer('designer_colors_sleeve_right')->default(0);
            $table->dateTime('designer_action_required_at')->nullable();
            $table->dateTime('designer_assigned_at')->nullable();
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
        Schema::drop('artwork_requests');
    }
}
