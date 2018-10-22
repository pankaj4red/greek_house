<?php

namespace App\Console;

use Symfony\Component\Console\Style\OutputStyle;

const CO_LINE_BREAK = 0b0001;
const CO_TIMESTAMP = 0b0010;

class ConsoleOutput
{
    /**
     * Enables or disables the console output
     *
     * @var bool
     */
    public static $verbose = false;

    /**
     * @var OutputStyle
     */
    protected static $consoleOutput = null;

    /**
     * @param OutputStyle $consoleOutput
     */
    public static function setConsoleOutput(OutputStyle $consoleOutput)
    {
        static::$consoleOutput = $consoleOutput;
    }

    /**
     * @return bool
     */
    public static function hasConsoleOutput()
    {
        return static::$consoleOutput !== null;
    }

    /**
     * @param bool $verbose
     */
    public static function setVerbose($verbose)
    {
        self::$verbose = $verbose;
    }

    /**
     * @return bool
     */
    public static function isVerbose()
    {
        return self::$verbose;
    }

    /**
     * @return OutputStyle
     */
    public static function getConsoleOutput()
    {
        if (! static::hasConsoleOutput()) {
            static::$consoleOutput = new ConsoleOutputEcho();
        }

        return static::$consoleOutput;
    }

    /**
     * Outputs a timetamp
     */
    public static function timestamp()
    {
        if (static::$verbose) {
            static::getConsoleOutput()->write('['.date('H:i:s').'] ');
        }
    }

    /**
     * @param string $message
     * @param int    $flags
     */
    public static function warning($message, $flags = 0b0)
    {
        if (static::$verbose) {
            if ($flags & CO_TIMESTAMP) {
                static::timestamp();
            }
            static::getConsoleOutput()->write('<fg=blue;bg=yellow>'.$message.'</>');
            if ($flags & CO_LINE_BREAK) {
                static::getConsoleOutput()->newLine();
            }
        }
    }

    /**
     * @param string $message
     * @param int    $flags
     */
    public static function error($message, $flags = 0b0)
    {
        if (static::$verbose) {
            if ($flags & CO_TIMESTAMP) {
                static::timestamp();
            }
            static::getConsoleOutput()->write('<error>'.$message.'</error>');
            if ($flags & CO_LINE_BREAK) {
                static::getConsoleOutput()->newLine();
            }
        }
    }

    /**
     * @param string $message
     * @param int    $flags
     */
    public static function success($message, $flags = 0b0)
    {
        if (static::$verbose) {
            if ($flags & CO_TIMESTAMP) {
                static::timestamp();
            }
            static::getConsoleOutput()->write('<fg=white;bg=blue>'.$message.'</>');
            if ($flags & CO_LINE_BREAK) {
                static::getConsoleOutput()->newLine();
            }
        }
    }

    /**
     * @param string $message
     * @param int    $flags
     */
    public static function info($message, $flags = 0b0)
    {
        if (static::$verbose) {
            if ($flags & CO_TIMESTAMP) {
                static::timestamp();
            }
            static::getConsoleOutput()->write('<info>'.$message.'</info>');
            if ($flags & CO_LINE_BREAK) {
                static::getConsoleOutput()->newLine();
            }
        }
    }

    /**
     * @param string $message
     * @param int    $flags
     */
    public static function comment($message, $flags = 0b0)
    {
        if (static::$verbose) {
            if ($flags & CO_TIMESTAMP) {
                static::timestamp();
            }
            static::getConsoleOutput()->write('<comment>'.$message.'</comment>');
            if ($flags & CO_LINE_BREAK) {
                static::getConsoleOutput()->newLine();
            }
        }
    }

    /**
     * @param string $message
     * @param int    $flags
     */
    public static function text($message, $flags = 0b0)
    {
        if (static::$verbose) {
            if ($flags & CO_TIMESTAMP) {
                static::timestamp();
            }
            static::getConsoleOutput()->write('<text>'.$message.'</text>');
            if ($flags & CO_LINE_BREAK) {
                static::getConsoleOutput()->newLine();
            }
        }
    }

    /**
     * @param string $title
     */
    public static function title($title)
    {
        if (static::$verbose) {
            static::getConsoleOutput()->newLine();
            static::getConsoleOutput()->writeln([
                sprintf('<comment>%s</comment>', $title),
                sprintf('<comment>%s</comment>', str_repeat('=', strlen($title))),
            ]);
            static::getConsoleOutput()->newLine();
        }
    }

    /**
     * @param string $title
     */
    public static function subtitle($title)
    {
        if (static::$verbose) {
            static::getConsoleOutput()->newLine();
            static::getConsoleOutput()->writeln([
                sprintf('<comment>%s</comment>', $title),
                sprintf('<comment>%s</comment>', str_repeat('-', strlen($title))),
            ]);
        }
    }

    /**
     * @param string $title
     * @param int    $flags
     */
    public static function listing($title, $flags = 0b0)
    {
        if (static::$verbose) {
            if ($flags & CO_TIMESTAMP) {
                static::timestamp();
            }
            static::getConsoleOutput()->listing([$title]);
            if ($flags & CO_LINE_BREAK) {
                static::getConsoleOutput()->newLine();
            }
        }
    }

    /**
     * Outputs a line break
     */
    public static function newLine()
    {
        if (static::$verbose) {
            static::getConsoleOutput()->newLine();
        }
    }
}
