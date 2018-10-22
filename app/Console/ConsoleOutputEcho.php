<?php

namespace App\Console;

/**
 * Class ConsoleOutputEcho
 *
 * @package App\Console
 * This class is a default fallback for displaying data whenever Laravel's Output class is not being used
 */
class ConsoleOutputEcho
{
    /**
     * Writes a string
     *
     * @param $output
     */
    public function write($output)
    {
        echo $output;
    }

    /**
     * Outputs a line break
     */
    public function newLine()
    {
        echo "\n";
    }

    /**
     * Outputs a line
     *
     * @param $output
     */
    public function writeln($output)
    {
        $this->write($output);
        $this->newLine();
    }
}