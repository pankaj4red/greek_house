<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sf_id')->nullable();
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('school')->nullable();
            $table->string('chapter')->nullable();
            $table->string('email')->unique();
            $table->integer('address_id')->unsigned()->nullable()->index();
            $table->string('password_old')->nullable();
            $table->string('password', 60)->nullable();
            $table->string('type_code')->default('customer');
            $table->integer('avatar_id')->unsigned()->nullable()->index();
            $table->integer('avatar_thumbnail_id')->unsigned()->nullable()->index();
            $table->string('billing_customer_id')->nullable();
            $table->string('billing_card_id')->nullable();
            $table->string('activation_code')->nullable();
            $table->boolean('active')->default(1);
            $table->string('remember_token', 100)->nullable();
            $table->enum('school_year', ['freshman', 'sophomore', 'junior', 'senior', 'senior_5th'])->nullable()->default('freshman');
            $table->string('venmo_username')->nullable();
            $table->integer('school_id')->unsigned()->nullable()->index();
            $table->integer('chapter_id')->unsigned()->nullable()->index();
            $table->decimal('hourly_rate')->default(30.00);
            $table->integer('account_manager_id')->unsigned()->nullable()->index();
            $table->enum('decorator_status', ['ON', 'OFF'])->default('ON');
            $table->boolean('decorator_screenprint_enabled')->default(1);
            $table->boolean('decorator_embroidery_enabled')->default(1);
            $table->enum('on_hold_state', ['enabled', 'disabled'])->default('enabled');
            $table->dateTime('last_login_at')->nullable();
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
        Schema::drop('users');
    }
}
