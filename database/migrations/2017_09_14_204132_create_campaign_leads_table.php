<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCampaignLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('distinct_id')->unsigned()->nullable()->index();
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->integer('color_id')->unsigned()->nullable()->index();
            $table->integer('size_id')->unsigned()->nullable()->index();
            $table->integer('free_product_id')->unsigned()->nullable()->index();
            $table->integer('free_product_color_id')->unsigned()->nullable()->index();
            $table->integer('free_product_size_id')->unsigned()->nullable()->index();
            $table->integer('gender_id')->unsigned()->nullable()->index();
            $table->integer('category_id')->unsigned()->nullable()->index();
            $table->integer('image1_id')->unsigned()->nullable()->index();
            $table->integer('image2_id')->unsigned()->nullable()->index();
            $table->integer('image3_id')->unsigned()->nullable()->index();
            $table->integer('image4_id')->unsigned()->nullable()->index();
            $table->integer('image5_id')->unsigned()->nullable()->index();
            $table->integer('image6_id')->unsigned()->nullable()->index();
            $table->integer('image7_id')->unsigned()->nullable()->index();
            $table->integer('image8_id')->unsigned()->nullable()->index();
            $table->integer('image9_id')->unsigned()->nullable()->index();
            $table->integer('image10_id')->unsigned()->nullable()->index();
            $table->integer('image11_id')->unsigned()->nullable()->index();
            $table->integer('image12_id')->unsigned()->nullable()->index();
            $table->integer('campaign_id')->unsigned()->nullable()->index();
            $table->integer('source_design_id')->unsigned()->nullable()->index();
            $table->integer('school_id')->unsigned()->nullable()->index();
            $table->integer('chapter_id')->unsigned()->nullable()->index();
            $table->enum('state', ['new', 'converted'])->default('new');
            $table->enum('budget', ['yes', 'no'])->default('no');
            $table->string('budget_range')->nullable();
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
            $table->string('contact_first_name')->nullable();
            $table->string('contact_last_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_school')->nullable();
            $table->string('contact_chapter')->nullable();
            $table->string('address_name')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_zip_code')->nullable();
            $table->string('address_country')->nullable();
            $table->boolean('address_save')->nullable();
            $table->enum('design_style_preference', ['cartoon', 'realistic_sketch', 'mixed_graphic', 'line_art', 'typographical', 'graphic_stamp'])->default('cartoon');
            $table->string('flexible')->nullable();
            $table->string('date')->nullable();
            $table->string('design_type')->default('screen');
            $table->string('estimated_quantity')->nullable();
            $table->string('promo_code')->nullable();
            $table->string('size_short')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->boolean('rush')->default(0);
            $table->boolean('question_wear_men')->default(0);
            $table->boolean('question_wear_women')->default(0);
            $table->boolean('question_wear_members')->default(0);
            $table->boolean('question_wear_parents')->default(0);
            $table->boolean('question_wear_alumni')->default(0);
            $table->boolean('question_wear_dates')->default(0);
            $table->string('question_wear_other')->default('');
            $table->enum('question_who_for', ['none', 'fraternity_sorority', 'student', 'business', 'other'])->default('none');
            $table->string('question_who_for_other')->default('');
            $table->timestamps();
            $table->softDeletes();
            $table->string('address_option')->default('dontsave');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_leads');
    }
}
