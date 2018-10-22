<?php

namespace App\Helpers\FakeProviders;

class DesignTagThemesFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        "Anchor Splash",
        "Bar Crawl",
        "Bid Day",
        "Big Little",
        "Christmas",
        "Dad's Day",
        "Dad's Weekend",
        "Dance Marathon",
        "Date Night/Date Party/Grab a Date",
        "Derby Days",
        "Feathers",
        "Formal",
        "Founders Day",
        "Fundraiser",
        "Gameday/Tailgate",
        "Halloween",
        "Homecoming",
        "Initiation",
        "Lip Sync",
        "Mixers & Socials",
        "Mom's Day",
        "Mom's Weekend",
        "Mountain Weekend",
        "Mr/Mrs. Greek",
        "New Member Retreat",
        "Parents Weekend",
        "Philanthropy",
        "Recruiment",
        "Relay 4 Life",
        "Retreat",
        "Rush",
        "Slope Day",
        "Social/Mixer/Swap",
        "Songfest",
        "Spirit Week",
        "Spring Break",
        "Crush",
        "Spring Day",
        "St. Jude",
        "St. Patricks Day",
        "Stars and Crescent Ball",
        "Tailgate",
        "Thanksgiving",
        "Think Pink",
        "Turtle Tug",
        "Valentine's Day",
        "Weekend Getaway",
        "Welcome Week",
        "Work Week",
        "Intramural",
        "Sisterhood retreat",
        "BBQ",
        "Woodser",
    ];

    public function design_tag_themes()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}