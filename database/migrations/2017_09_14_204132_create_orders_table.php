<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('campaign_id')->unsigned()->nullable()->index();
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->integer('color_id')->unsigned()->nullable()->index();
            $table->integer('quantity');
            $table->decimal('subtotal');
            $table->decimal('shipping');
            $table->decimal('tax');
            $table->decimal('total');
            $table->enum('state', ['new', 'failed', 'authorized', 'authorized_processing', 'authorized_failed', 'success', 'refund', 'cancelled'])->default('new');
            $table->string('state_details')->nullable();
            $table->string('contact_first_name')->nullable();
            $table->string('contact_last_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_chapter')->nullable();
            $table->string('contact_school')->nullable();
            $table->string('shipping_line1')->nullable();
            $table->string('shipping_line2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip_code')->nullable();
            $table->string('shipping_country')->nullable()->default('usa');
            $table->enum('shipping_type', ['individual', 'group'])->default('group');
            $table->enum('payment_type', ['individual', 'group'])->default('group');
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_line1')->nullable();
            $table->string('billing_line2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip_code')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_provider')->nullable();
            $table->string('billing_customer_id')->nullable();
            $table->string('billing_card_id')->nullable();
            $table->string('billing_charge_id')->nullable();
            $table->text('billing_details', 65535)->nullable();
            $table->string('tracking_code')->nullable();
            $table->integer('school_id')->unsigned()->nullable()->index();
            $table->integer('chapter_id')->unsigned()->nullable()->index();
            $table->dateTime('authorized_at')->nullable();
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
        Schema::drop('orders');
    }
}
