<?php

namespace App\Notifications;

use App\Channels\CustomDatabaseChannel;
use App\Models\Notification as NotificationModel;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationRequested extends Notification
{
    use Queueable;

    protected $reservation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [CustomDatabaseChannel::class];
    }

    /**
     * Get the array representation of the notification for the custom database channel.
     */
    public function toCustomDatabase(object $notifiable): array
    {
        return [
            'type'    => NotificationModel::TYPE_MESSAGE,
            'titre'   => "Nouvelle demande de réservation pour '{$this->reservation->ressource->nom}'",
            'contenu' => "L'utilisateur {$this->reservation->demandeur->nom} a fait une demande de réservation pour le '{$this->reservation->debut->format('d/m/Y H:i')}'.",
            'lien'    => route('admin.reservations.index'), // Lien vers la gestion des réservations
        ];
    }
}
