<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('caption');
            $table->boolean('is_staff');
            $table->boolean('is_admin');
            $table->boolean('is_designer');
            $table->boolean('is_support');
            $table->boolean('is_director');
            $table->boolean('is_decorator');
            $table->boolean('can_see_full_names');
            $table->boolean('can_see_all_campaigns');
            $table->boolean('can_access_admin');
            $table->boolean('sees_customer_quick_quote');
            $table->boolean('sees_support_quick_quote');
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
        Schema::drop('user_types');
    }
}
