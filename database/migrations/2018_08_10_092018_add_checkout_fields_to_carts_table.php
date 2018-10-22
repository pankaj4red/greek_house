<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckoutFieldsToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->string('contact_first_name')->after('user_id')->nullable();
            $table->string('contact_last_name')->after('contact_first_name')->nullable();
            $table->string('contact_email')->after('contact_last_name')->nullable();
            $table->string('contact_phone')->after('contact_email')->nullable();
            $table->string('contact_school')->after('contact_phone')->nullable();
            $table->string('contact_chapter')->after('contact_school')->nullable();
            $table->string('contact_graduation_year')->after('contact_chapter')->nullable();

            $table->string('billing_line1')->after('contact_graduation_year')->nullable();
            $table->string('billing_line2')->after('billing_line1')->nullable();
            $table->string('billing_city')->after('billing_line2')->nullable();
            $table->string('billing_state')->after('billing_city')->nullable();
            $table->string('billing_zip_code')->after('billing_state')->nullable();

            $table->string('shipping_line1')->after('billing_zip_code')->nullable();
            $table->string('shipping_line2')->after('shipping_line1')->nullable();
            $table->string('shipping_city')->after('shipping_line2')->nullable();
            $table->string('shipping_state')->after('shipping_city')->nullable();
            $table->string('shipping_zip_code')->after('shipping_state')->nullable();

            $table->enum('shipping_type', ['individual', 'group'])->after('billing_zip_code')->default('group');
            $table->enum('payment_type', ['individual', 'group'])->after('shipping_type')->default('group');
            $table->string('payment_method')->after('payment_type')->default('');
            $table->string('payment_nonce')->after('payment_method')->nullable();
            $table->boolean('allow_marketing')->after('payment_nonce')->default(false);
            $table->enum('state', ['open', 'closed'])->after('allow_marketing')->default('open');
            $table->string('billing_provider')->after('state')->nullable();
            $table->string('billing_customer_id', 2096)->after('billing_provider')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn([
                'contact_first_name',
                'contact_last_name',
                'contact_email',
                'contact_phone',
                'billing_line1',
                'billing_line2',
                'billing_city',
                'billing_state',
                'billing_zip_code',
                'shipping_line1',
                'shipping_line2',
                'shipping_city',
                'shipping_state',
                'shipping_zip_code',
                'contact_first_name',
                'shipping_type',
                'payment_type',
                'payment_nonce',
                'allow_marketing',
                'state',
            ]);
        });
    }
}
