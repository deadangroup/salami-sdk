<?php

namespace DGL\Salami\Notifications;

use DGL\Salami\Sms;
use Illuminate\Notifications\Notification;

/**
 *
 */
class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = (string) $notification->toSms($notifiable);

        try {
            // We are assuming we are notifying a user or a model that has a telephone attribute/field.
            // And the telephone number is correctly formatted.
            return Sms::send($notifiable->routeNotificationFor('sms', $notification), $message);
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage());
        }
    }
}
