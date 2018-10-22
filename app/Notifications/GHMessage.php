<?php

namespace App\Notifications;

use Illuminate\Notifications\Action;
use Illuminate\Notifications\Messages\MailMessage;

class GHMessage extends MailMessage implements NotificationMessage
{
    protected $table;

    protected $hello;

    public function hello($hello)
    {
        $this->hello = $hello;

        return $this;
    }

    public function table($rows, $header = [])
    {
        $this->table = ['header' => $header, 'rows' => $rows];

        return $this;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), ['hello' => $this->hello, 'table' => $this->table]);
    }

    public function with($line)
    {
        if ($line instanceof Action) {
            $this->action($line->text, $line->url);
        } elseif (! $this->actionText && ! $this->table) {
            $this->introLines[] = $this->formatLine($line);
        } else {
            $this->outroLines[] = $this->formatLine($line);
        }

        return $this;
    }
}