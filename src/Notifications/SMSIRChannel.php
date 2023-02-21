<?php
/**
 * mahdirashidi.developer@gmail.com
 */
namespace MRGear\SMSIR\Notifications;

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