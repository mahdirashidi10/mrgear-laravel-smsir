<?php
/**
 * mahdirashidi.developer@gmail.com
 */
namespace MRGear\SMSIR\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use MRGear\SMSIR\SMSIR;

class SMSIRNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $data;

    public function __construct($message = true, $data = null)
    {
        if (is_array($message)){
            $data = $message;
            $message = true;
        }
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Get the notification channels.
     *
     * @param mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return config('smsir.channels');
    }

    /**
     * Get the voice representation of the notification.
     *
     * @param mixed $notifiable
     * @throws \Exception
     */
    public function toSms($notifiable)
    {
        $phone_number = $notifiable->{$notifiable->smsir_phone_number ?? 'phone_number'};
        if(empty($phone_number)){
            throw new \RuntimeException('The phone_number column is not set correctly | [public smsir_phone_number]');
        }
        $SMSIR = new SMSIR();
        switch (true):
            case $this->message === true:
                $SMSIR->templateId($this->data['template_id'] ?? null)
                    ->phoneNumber($phone_number)
                    ->parameters(Arr::except($this->data , ['template_id']))
                    ->fast()
                    ->send();
                break;
            case is_string($this->message):
                $SMSIR->message($this->message)
                    ->phoneNumber($phone_number)
                    ->single()
                    ->send();
                break;
            default:
                throw new \RuntimeException('The message not set currently | MESSAGE => BOOL|STRING');
        endswitch;
    }
}