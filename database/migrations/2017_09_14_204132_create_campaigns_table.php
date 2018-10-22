<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('manager_id')->unsigned()->nullable()->index();
            $table->integer('designer_id')->unsigned()->nullable()->index();
            $table->integer('fulfillment_id')->unsigned()->nullable()->index();
            $table->integer('decorator_id')->unsigned()->nullable()->index();
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->integer('color_id')->unsigned()->nullable()->index();
            $table->integer('size_id')->unsigned()->nullable()->index();
            $table->integer('artwork_id')->unsigned()->nullable()->index();
            $table->integer('source_design_id')->unsigned()->nullable()->index();
            $table->integer('artwork_request_id')->unsigned()->nullable()->index();
            $table->integer('free_product_id')->unsigned()->nullable()->index();
            $table->integer('free_product_size_id')->unsigned()->nullable()->index();
            $table->integer('free_product_color_id')->unsigned()->nullable()->index();
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
            $table->enum('design_style_preference', ['none', 'cartoon', 'realistic_sketch', 'mixed_graphic', 'line_art', 'typographical', 'graphic_stamp'])->default('none');
            $table->integer('designer_colors_front')->default(0);
            $table->integer('designer_colors_back')->default(0);
            $table->integer('designer_colors_sleeve_left')->default(0);
            $table->integer('designer_colors_sleeve_right')->default(0);
            $table->enum('estimated_quantity', ['12-23', '24-47', '48-71', '72-143', '144+'])->default('24-47');
            $table->string('flexible');
            $table->string('date')->nullable();
            $table->string('design_type')->default('screen');
            $table->enum('state', [
                'on_hold',
                'campus_approval',
                'awaiting_design',
                'awaiting_approval',
                'revision_requested',
                'selecting_payment',
                'awaiting_quote',
                'collecting_payment',
                'processing_payment',
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
                'cancelled',
            ])->default('awaiting_design');
            $table->string('on_hold_category')->nullable();
            $table->string('on_hold_rule')->nullable();
            $table->integer('on_hold_actor')->nullable();
            $table->string('on_hold_reason')->nullable();
            $table->enum('budget', ['yes', 'no'])->default('no');
            $table->string('budget_range')->nullable();
            $table->integer('design_minutes')->default(0);
            $table->boolean('shipping_group')->default(1);
            $table->boolean('shipping_individual')->default(0);
            $table->integer('proof1_id')->unsigned()->nullable()->index();
            $table->integer('proof2_id')->unsigned()->nullable()->index();
            $table->integer('proof3_id')->unsigned()->nullable()->index();
            $table->integer('proof4_id')->unsigned()->nullable()->index();
            $table->integer('proof5_id')->unsigned()->nullable()->index();
            $table->integer('proof6_id')->unsigned()->nullable()->index();
            $table->integer('proof7_id')->unsigned()->nullable()->index();
            $table->integer('proof8_id')->unsigned()->nullable()->index();
            $table->integer('proof9_id')->unsigned()->nullable()->index();
            $table->integer('proof10_id')->unsigned()->nullable()->index();
            $table->string('revision_text', 2048)->nullable();
            $table->decimal('quote_low')->nullable();
            $table->decimal('quote_high')->nullable();
            $table->decimal('quote_final')->nullable();
            $table->integer('markup')->nullable();
            $table->integer('image1_id')->unsigned()->nullable()->index();
            $table->integer('image2_id')->unsigned()->nullable()->index();
            $table->integer('image3_id')->unsigned()->nullable()->index();
            $table->integer('bag_tag_id')->unsigned()->nullable()->index();
            $table->dateTime('assigned_decorator_date')->nullable();
            $table->dateTime('printing_date')->nullable();
            $table->dateTime('scheduled_date')->nullable();
            $table->string('tracking_code')->nullable();
            $table->integer('print_file1_id')->unsigned()->nullable()->index();
            $table->integer('print_file2_id')->unsigned()->nullable()->index();
            $table->integer('print_file3_id')->unsigned()->nullable()->index();
            $table->integer('print_file4_id')->unsigned()->nullable()->index();
            $table->integer('print_file5_id')->unsigned()->nullable()->index();
            $table->integer('print_file6_id')->unsigned()->nullable()->index();
            $table->integer('print_file7_id')->unsigned()->nullable()->index();
            $table->integer('print_file8_id')->unsigned()->nullable()->index();
            $table->integer('print_file9_id')->unsigned()->nullable()->index();
            $table->integer('print_file10_id')->unsigned()->nullable()->index();
            $table->dateTime('close_date')->nullable();
            $table->boolean('closing_24h_mail_sent')->default(0);
            $table->integer('closing_fail_retry')->default(0);
            $table->boolean('closing_fail_mail_sent')->default(0);
            $table->dateTime('processed_at')->nullable();
            $table->integer('school_id')->unsigned()->nullable()->index();
            $table->integer('chapter_id')->unsigned()->nullable()->index();
            $table->boolean('rush')->default(0);
            $table->boolean('polybag_and_label')->default(1);
            $table->string('fulfillment_shipping_name')->nullable();
            $table->string('fulfillment_shipping_phone')->nullable();
            $table->string('fulfillment_shipping_line1')->nullable();
            $table->string('fulfillment_shipping_line2')->nullable();
            $table->string('fulfillment_shipping_city')->nullable();
            $table->string('fulfillment_shipping_state')->nullable();
            $table->string('fulfillment_shipping_zip_code')->nullable();
            $table->string('fulfillment_shipping_country')->nullable();
            $table->dateTime('garment_arrival_date')->nullable();
            $table->dateTime('printer_shipping_date')->nullable();
            $table->decimal('invoice_total')->nullable();
            $table->decimal('hourly_rate')->nullable();
            $table->boolean('designer_black_shirt')->default(0);
            $table->text('reminder_awaiting_approval', 65535)->nullable();
            $table->text('reminder_collecting_payment', 65535)->nullable();
            $table->text('reminder_deadline', 65535)->nullable();
            $table->dateTime('awaiting_approval_at')->nullable();
            $table->dateTime('awaiting_design_at')->nullable();
            $table->dateTime('revision_requested_at')->nullable();
            $table->dateTime('awaiting_quote_at')->nullable();
            $table->dateTime('collecting_payment_at')->nullable();
            $table->dateTime('processing_payment_at')->nullable();
            $table->dateTime('processing_payment_time')->nullable();
            $table->dateTime('fulfillment_ready_at')->nullable();
            $table->dateTime('fulfillment_validation_at')->nullable();
            $table->dateTime('printing_at')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->enum('followup_awaiting_approval', ['yes', 'no'])->nullable();
            $table->enum('followup_collecting_payment', ['yes', 'no'])->nullable();
            $table->enum('followup_deadline', ['yes', 'no'])->nullable();
            $table->dateTime('followup_awaiting_approval_date')->nullable();
            $table->dateTime('followup_collecting_payment_date')->nullable();
            $table->dateTime('followup_deadline_date')->nullable();
            $table->enum('reminders', ['on', 'off'])->nullable();
            $table->text('account_manager_notes', 65535)->nullable();
            $table->dateTime('designer_action_required_at')->nullable();
            $table->integer('revision_count')->default(0);
            $table->integer('campus_approval_time')->default(0);
            $table->integer('awaiting_design_time')->default(0);
            $table->integer('awaiting_approval_time')->default(0);
            $table->integer('revision_requested_time')->default(0);
            $table->integer('awaiting_quote_time')->default(0);
            $table->integer('collecting_payment_time')->default(0);
            $table->integer('fulfillment_ready_time')->default(0);
            $table->integer('fulfillment_validation_time')->default(0);
            $table->integer('printing_time')->default(0);
            $table->integer('shipped_time')->default(0);
            $table->dateTime('designer_assigned_at')->nullable();
            $table->enum('followup_no_orders', ['yes', 'no'])->nullable();
            $table->integer('on_hold_time')->nullable();
            $table->dateTime('on_hold_at')->nullable();
            $table->decimal('shipping_cost')->nullable();
            $table->decimal('royalty')->nullable();
            $table->decimal('royalty_rate')->nullable();
            $table->decimal('commission_manager_rate')->nullable();
            $table->decimal('commission_manager')->nullable();
            $table->decimal('commission_sales_rep_rate')->nullable();
            $table->decimal('commission_sales_rep')->nullable();
            $table->string('sf_id')->nullable();
            $table->enum('speciality_inks', ['yes', 'no'])->default('no');
            $table->enum('embellishment_names', ['yes', 'no'])->default('no');
            $table->enum('embellishment_numbers', ['yes', 'no'])->default('no');
            $table->dateTime('due_at')->nullable();
            $table->integer('days_in_transit')->default(0);
            $table->enum('decorator_pocket', ['yes', 'no'])->default('no');
            $table->boolean('fulfillment_valid')->nullable()->default(1);
            $table->enum('fulfillment_invalid_reason', ['Garment', 'Artwork', 'Other'])->nullable();
            $table->text('fulfillment_invalid_text', 65535)->nullable();
            $table->string('promo_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->text('notes', 65535)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaigns');
    }
}
