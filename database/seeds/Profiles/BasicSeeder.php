<?php

class BasicSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new DesignTagGroupSeeder())->run();
        (new BudgetSeeder())->run();
        (new CampaignStateSeeder())->run();
        (new UserTypeSeeder())->run();
    }
}