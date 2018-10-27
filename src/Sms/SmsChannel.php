<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Sms;

use Illuminate\Notifications\Notification;
use Log;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param                                        $user
     * @param \Illuminate\Notifications\Notification $notification
     */
    public function send($user, Notification $notification)
    {
        if (!$to = $user->routeNotificationFor('sms')) {
            return;
        }
        $message = $notification->toSms($user);
        if ($message instanceof SmsMessage) {
            $message = $message->getContent();
        }
        if (!is_string($message)) {
            return;
        }
        Log::info("SmsChannel.msgContent:" . $message);

        $payload = [
            'to'      => $to,
            'message' => $message,
        ];

        //send it baby!
        app('deadan_sms')->send($payload);
    }
}