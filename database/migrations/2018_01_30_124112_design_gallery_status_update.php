<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DesignGalleryStatusUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*
         * Create status_new
         * Copy status to status_new
         * Drop status
         * Re-Create status
         * copy status_new to status
        */

        Schema::table('designs', function (Blueprint $table) {
            $table->enum('status_new', ['new', 'disabled', 'enabled', 'search'])->default('new')->after('status');
        });

        DB::update('update designs set `status_new` = `status`');

        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('designs', function (Blueprint $table) {
            $table->enum('status', ['new', 'disabled', 'enabled', 'search'])->default('new')->index('status')->after('status_new');
        });

        DB::update('update designs set `status` = `status_new`');

        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('status_new');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Destructive down?
        Schema::table('designs', function (Blueprint $table) {
            $table->enum('status_new', ['new', 'disabled', 'enabled', 'search'])->default('new')->after('status');
        });

        DB::update('update designs set `status_new` = `status`');

        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('designs', function (Blueprint $table) {
            $table->enum('status', ['new', 'disabled', 'enabled'])->default('new')->index('status')->after('status_new');
        });

        DB::update('update designs set `status_new` = enabled where `status` = enabled');
        DB::update('update designs set `status` = `status_new`');

        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('status_new');
        });
    }
}
