<?php

use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo '['.\Carbon\Carbon::now()->format('Y-m-d H:i:s').'] Started'.PHP_EOL;
        Model::unsetEventDispatcher();
        $this->clearFiles();

        (new DevSeeder())->run();
        echo '['.\Carbon\Carbon::now()->format('Y-m-d H:i:s').'] Ended'.PHP_EOL;
    }
}
