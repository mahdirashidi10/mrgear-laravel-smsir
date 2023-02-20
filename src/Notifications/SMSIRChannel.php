<?php

namespace MRGear\SMSIR\Notification;

use Illuminate\Notifications\Notification;

class SMSIRChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
    }
}