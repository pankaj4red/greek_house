<?php

class BudgetSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        budget_repository()->create([
            'code'    => '<$14',
            'caption' => '<$14',
            'from'    => 0,
            'to'      => 14.99,
        ]);
        budget_repository()->create([
            'code'    => '$15-$18',
            'caption' => '$15-$18',
            'from'    => 15,
            'to'      => 18.99,
        ]);
        budget_repository()->create([
            'code'    => '$19-$23',
            'caption' => '$19-$23',
            'from'    => 19,
            'to'      => 23.99,
        ]);
        budget_repository()->create([
            'code'    => '>$24',
            'caption' => '$24 or more',
            'from'    => 24,
            'to'      => 9999999,
        ]);
    }
}