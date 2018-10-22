<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned()->nullable()->index();
            $table->integer('order_id')->unsigned()->nullable()->index();
            $table->string('response_reason_text_displayed', 1024)->nullable();
            $table->string('x_response_code')->nullable();
            $table->string('x_response_reason_code')->nullable();
            $table->string('x_response_reason_text', 1024)->nullable();
            $table->string('x_auth_code')->nullable();
            $table->string('x_trans_id')->nullable();
            $table->string('x_invoice_num')->nullable();
            $table->string('x_description')->nullable();
            $table->string('x_amount')->nullable();
            $table->string('x_tax')->nullable();
            $table->string('x_method')->nullable();
            $table->string('x_type')->nullable();
            $table->string('x_MD5_Hash')->nullable();
            $table->string('x_cvv2_resp_code')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
