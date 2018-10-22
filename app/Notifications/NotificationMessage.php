<?php

namespace App\Notifications;

interface NotificationMessage
{
    /**
     * @param string $line
     * @return $this
     */
    public function line($line);

    /**
     * @param string $name
     * @return $this
     */
    public function hello($name);

    /**
     * @param string $subject
     * @return $this
     */
    public function subject($subject);
}