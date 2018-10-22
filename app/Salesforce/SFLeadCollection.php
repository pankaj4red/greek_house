<?php

namespace App\Salesforce;

use Illuminate\Support\Collection;

class SFLeadCollection extends Collection
{
    /**
     * SFLeadCollection constructor.
     *
     * @param SFLead[] $items
     */
    public function __construct($items = [])
    {
        parent::__construct($items);
    }
}