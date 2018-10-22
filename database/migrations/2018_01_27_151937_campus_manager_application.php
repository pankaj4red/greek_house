<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CampusManagerApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campus_managers', function (Blueprint $table) {
            if (! Schema::hasColumn('campus_managers', 'year')) {
                $table->string('year')->nullable()->after('instagram');
            }
            if (! Schema::hasColumn('campus_managers', 'description')) {
                $table->text('description', 65535)->nullable()->after('year');
            }
            if (! Schema::hasColumn('campus_managers', 'positions')) {
                $table->text('positions', 65535)->nullable()->after('description');
            }
            if (! Schema::hasColumn('campus_managers', 'major')) {
                $table->string('major', 255)->nullable()->after('positions');
            }
            if (! Schema::hasColumn('campus_managers', 'top_brands')) {
                $table->string('top_brands')->nullable()->after('major');
            }
            if (! Schema::hasColumn('campus_managers', 'sf_id')) {
                $table->string('sf_id')->nullable()->after('top_brands');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campus_managers', function (Blueprint $table) {
            if (Schema::hasColumn('campus_managers', 'year')) {
                $table->dropColumn('year');
            }
            if (Schema::hasColumn('campus_managers', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('campus_managers', 'positions')) {
                $table->dropColumn('positions');
            }
            if (Schema::hasColumn('campus_managers', 'major')) {
                $table->dropColumn('major');
            }
            if (Schema::hasColumn('campus_managers', 'top_brands')) {
                $table->dropColumn('top_brands');
            }
            if (Schema::hasColumn('campus_managers', 'sf_id')) {
                $table->dropColumn('sf_id');
            }
        });
    }
}
