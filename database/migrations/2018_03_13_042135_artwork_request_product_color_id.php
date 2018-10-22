<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArtworkRequestProductColorId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artwork_request_files', function (Blueprint $table) {
            $table->integer('product_color_id')->unsigned()->nullable()->index()->after('file_id');
        });

        DB::statement('update artwork_request_files set type = ? where type = ?', ['proof_generic', 'proof']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artwork_request_files', function (Blueprint $table) {
            $table->dropColumn('product_color_id');
        });

        DB::statement('update artwork_request_files set type = ? where type like ?', ['proof', 'proof']);
    }
}
