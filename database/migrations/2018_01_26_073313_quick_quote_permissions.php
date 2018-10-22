<?php

use Illuminate\Database\Migrations\Migration;

class QuickQuotePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update('update user_types set sees_customer_quick_quote = 0 where code = ?', ['customer']);
        DB::update('update user_types set sees_customer_quick_quote = 0 where code = ?', ['sales_rep']);
        DB::update('update user_types set sees_customer_quick_quote = 0 where code = ?', ['account_manager']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update('update user_types set sees_customer_quick_quote = 1 where code = ?', ['customer']);
        DB::update('update user_types set sees_customer_quick_quote = 1 where code = ?', ['sales_rep']);
        DB::update('update user_types set sees_customer_quick_quote = 1 where code = ?', ['account_manager']);
    }
}
