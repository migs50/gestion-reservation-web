<?php

namespace App\Notifications;

use App\Channels\CustomDatabaseChannel;
use App\Models\Notification as NotificationModel;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationDecision extends Notification
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
        $statusLabel = $this->reservation->statut === 'approved' ? 'approuvée' : 'refusée';
        
        return [
            'type'    => NotificationModel::TYPE_DECISION,
            'titre'   => "Décision sur votre réservation #{$this->reservation->id}",
            'contenu' => "Votre demande de réservation pour la ressource '{$this->reservation->ressource->nom}' a été {$statusLabel}.",
            'lien'    => route('reservations.index'), // Ou une page de détails si elle existe
        ];
    }
}
