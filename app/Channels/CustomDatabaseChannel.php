<?php

namespace App\Channels;

use Illuminate\Notifications\Notification as LaravelNotification;
use App\Models\Notification as NotificationModel;

class CustomDatabaseChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, LaravelNotification $notification)
    {
        $data = $notification->toCustomDatabase($notifiable);

        NotificationModel::create([
            'user_id' => $notifiable->id,
            'type'    => $data['type'] ?? NotificationModel::TYPE_MESSAGE,
            'titre'   => $data['titre'],
            'contenu' => $data['contenu'],
            'lien'    => $data['lien'] ?? null,
            'lu'      => false,
        ]);
    }
}
