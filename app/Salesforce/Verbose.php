<?php

namespace App\Salesforce;

use App\Console\ConsoleOutput;

trait Verbose
{
    private function verboseStart($text)
    {
        if (ConsoleOutput::isVerbose()) {
            ConsoleOutput::info($text, \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);
        }
    }

    private function verboseEnd($count)
    {
        if (ConsoleOutput::isVerbose()) {
            ConsoleOutput::comment('('.$count.')', \App\Console\CO_TIMESTAMP);
            ConsoleOutput::success('[Done]', \App\Console\CO_LINE_BREAK);
        }
    }

    private function verbose($text)
    {
        if (ConsoleOutput::isVerbose()) {
            ConsoleOutput::info($text, \App\Console\CO_TIMESTAMP | \App\Console\CO_LINE_BREAK);
        }
    }
}