<?php

namespace App\Helpers\FakeProviders;

class USStateFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        ['short' => 'AL', 'name' => 'Alabama'],
        ['short' => 'AK', 'name' => 'Alaska'],
        ['short' => 'AZ', 'name' => 'Arizona'],
        ['short' => 'AR', 'name' => 'Arkansas'],
        ['short' => 'CA', 'name' => 'California'],
        ['short' => 'CO', 'name' => 'Colorado'],
        ['short' => 'CT', 'name' => 'Connecticut'],
        ['short' => 'DE', 'name' => 'Delaware'],
        ['short' => 'FL', 'name' => 'Florida'],
        ['short' => 'GA', 'name' => 'Georgia'],
        ['short' => 'HI', 'name' => 'Hawaii'],
        ['short' => 'ID', 'name' => 'Idaho'],
        ['short' => 'IL', 'name' => 'Illinois'],
        ['short' => 'IN', 'name' => 'Indiana'],
        ['short' => 'IA', 'name' => 'Iowa'],
        ['short' => 'KS', 'name' => 'Kansas'],
        ['short' => 'KY', 'name' => 'Kentucky'],
        ['short' => 'LA', 'name' => 'Louisiana'],
        ['short' => 'ME', 'name' => 'Maine'],
        ['short' => 'MD', 'name' => 'Maryland'],
        ['short' => 'MA', 'name' => 'Massachusetts'],
        ['short' => 'MI', 'name' => 'Michigan'],
        ['short' => 'MN', 'name' => 'Minnesota'],
        ['short' => 'MS', 'name' => 'Mississippi'],
        ['short' => 'MO', 'name' => 'Missouri'],
        ['short' => 'MT', 'name' => 'Montana'],
        ['short' => 'NE', 'name' => 'Nebraska'],
        ['short' => 'NV', 'name' => 'Nevada'],
        ['short' => 'NH', 'name' => 'New Hampshire'],
        ['short' => 'NJ', 'name' => 'New Jersey'],
        ['short' => 'NM', 'name' => 'New Mexico'],
        ['short' => 'NY', 'name' => 'New York'],
        ['short' => 'NC', 'name' => 'North Carolina'],
        ['short' => 'ND', 'name' => 'North Dakota'],
        ['short' => 'OH', 'name' => 'Ohio'],
        ['short' => 'OK', 'name' => 'Oklahoma'],
        ['short' => 'OR', 'name' => 'Oregon'],
        ['short' => 'PA', 'name' => 'Pennsylvania'],
        ['short' => 'RI', 'name' => 'Rhode Island'],
        ['short' => 'SC', 'name' => 'South Carolina'],
        ['short' => 'SD', 'name' => 'South Dakota'],
        ['short' => 'TN', 'name' => 'Tennessee'],
        ['short' => 'TX', 'name' => 'Texas'],
        ['short' => 'UT', 'name' => 'Utah'],
        ['short' => 'VT', 'name' => 'Vermont'],
        ['short' => 'VA', 'name' => 'Virginia'],
        ['short' => 'WA', 'name' => 'Washington'],
        ['short' => 'WV', 'name' => 'West Virginia'],
        ['short' => 'WI', 'name' => 'Wisconsin'],
        ['short' => 'WY', 'name' => 'Wyoming'],
    ];

    public function us_state()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}