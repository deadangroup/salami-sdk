<?php

namespace Deadan\Support\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Gcm\GcmChannel;
use NotificationChannels\Gcm\GcmMessage;

class BroadcastModelChanges extends Notification implements ShouldQueue
{
    use Queueable, TimedJob;
    /**
     * @var
     */
    public $model;

    /**
     * @var
     */
    public $action;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model, $action)
    {
        $this->model = $model;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $user
     *
     * @return array
     */
    public function via($user)
    {
        return [GcmChannel::class];
    }

    /**
     * @param $user
     *
     * @return GcmMessage
     */
    public function toGcm($user)
    {
        return GcmMessage::create()
            ->priority(GcmMessage::PRIORITY_HIGH)
            ->title(class_basename($this->model) . ' ' . ucfirst($this->action))
            ->message("Synchronisation in progress.")
            ->data('action', $this->action)
            ->data('class_name', class_basename($this->model))
            ->data('model', $this->model->toArray());
    }
}
