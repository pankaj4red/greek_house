<?php

namespace App\Repositories\Helpers;

class HelperRepository
{
    protected $data = [];

    public function __construct()
    {
        $this->data = json_decode(json_encode($this->data));
    }
}
