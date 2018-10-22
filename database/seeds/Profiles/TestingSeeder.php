<?php

class TestingSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new BasicSeeder())->run();
    }
}