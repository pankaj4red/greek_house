<?php

namespace App\Helpers\FakeProviders;

class ChapterFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'Alpha',
        'Beta',
        'Gamma',
        'Delta',
        'Epsilon',
        'Zeta',
        'Eta',
        'Theta',
        'Iota',
        'Kappa',
        'Lambda',
        'Mu',
        'Nu',
        'Xi',
        'Omicron',
        'Pi',
        'Rho',
        'Sigma',
        'Tau',
        'Upsilon',
        'Phi',
        'Chi',
        'Psi',
        'Omega',
    ];

    public function chapter()
    {
        return $this->list[rand(0, count($this->list) - 1)].' '.$this->list[rand(0, count($this->list) - 1)].' '.$this->list[rand(0, count($this->list) - 1)];
    }
}