<?php

namespace App\Quotes\Data;

class QuoteGroup
{
    private $key = '';

    private $title = '';

    private $lines = [];

    function __construct($key, $title)
    {
        $this->key = $key;
        $this->title = $title;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param $index
     * @return QuoteLine|null
     */
    public function getLine($index)
    {
        if (is_int($index)) {
            return $this->lines[$index];
        }
        foreach ($this->lines as $line) {
            if ($line->getKey() == $index) {
                return $line;
            }
        }

        return null;
    }

    public function addLine(QuoteLine $line)
    {
        $this->lines[] = $line;
    }

    public function getTotalFrom()
    {
        $total = 0;
        foreach ($this->lines as $line) {
            $total += $line->getTotalFrom();
        }

        return round($total, 2);
    }

    public function getTotalTo()
    {
        $total = 0;
        foreach ($this->lines as $line) {
            $total += $line->getTotalTo();
        }

        return round($total, 2);
    }

    public function toArray()
    {
        $lines = [];
        foreach ($this->lines as $line) {
            $lines[] = $line->toArray();
        }

        return [
            'key'   => $this->key,
            'title' => $this->title,
            'lines' => $lines,
            'total' => [$this->getTotalFrom(), $this->getTotalTo()],
        ];
    }
}
