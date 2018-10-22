<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGraduationYearUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('graduation_year')->nullable();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->string('contact_graduation_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('graduation_year');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('contact_graduation_year');
        });
    }
}
