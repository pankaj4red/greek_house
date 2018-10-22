<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable()->index();
            $table->string('action')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('result')->nullable();
            $table->string('message')->nullable();
            $table->string('billing_provider')->nullable();
            $table->string('billing_customer_id')->nullable();
            $table->string('billing_payment_method')->nullable();
            $table->string('billing_payment_method_id')->nullable();
            $table->text('billing_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_transactions');
    }
}
