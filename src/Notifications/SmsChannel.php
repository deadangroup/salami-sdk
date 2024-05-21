<?php
/*
 *
 *  This is file is part of DGL's tech stack.
 *
 *  @copyright (c) 2024, Deadan Group Limited (DGL).
 *  @link https://www.dgl.co.ke/products
 *  All rights reserved.
 *
 *  <code>Build something people want!</code>
 */

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
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        try {
            // We are assuming we are notifying a user or a model that has a telephone attribute/field.
            // And the telephone number is correctly formatted.
            $to = $notifiable->routeNotificationFor('sms', $notification);
            $message = (string)$notification->toSms($notifiable);

            if (empty($to)) {
                \Log::emergency("$to is not a valid phonenumber. Aborting");
                return;
            }

            if (empty($message)) {
                \Log::emergency("$message is an empty message. Aborting");
                return;
            }

            return Sms::send($to, $message);

        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage());
        }
    }
}
