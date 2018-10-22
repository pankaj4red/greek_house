<?php

namespace App\PrintTypes\Data;

class EstimatedRange
{
    public $code;

    public $from;

    public $to;

    public $markup;

    public function __construct($code, $from, $to, $markup)
    {
        $this->code = $code;
        $this->from = $from;
        $this->to = $to;
        $this->markup = $markup;
    }
}
