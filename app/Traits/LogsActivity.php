<?php

namespace App\Traits;

use App\Models\Journal;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Log an action to the journal
     *
     * @param string $action The action performed (create, update, delete, etc.)
     * @param string $objet The object type (Reservation, Ressource, etc.)
     * @param int $objet_id The ID of the object
     * @param string $details Additional details about the action
     * @param int|null $acteur_id The user who performed the action (defaults to current user)
     */
    protected function logAction($action, $objet, $objet_id, $details = null, $acteur_id = null)
    {
        Journal::create([
            'acteur_id' => $acteur_id ?? Auth::id(),
            'action' => $action,
            'objet' => $objet,
            'objet_id' => $objet_id,
            'details' => $details
        ]);
    }

    /**
     * Log a creation action
     */
    protected function logCreation($objet, $objet_id, $details = null)
    {
        $this->logAction('create', $objet, $objet_id, $details ?? "{$objet} créé");
    }

    /**
     * Log an update action
     */
    protected function logUpdate($objet, $objet_id, $details = null)
    {
        $this->logAction('update', $objet, $objet_id, $details ?? "{$objet} mis à jour");
    }

    /**
     * Log a deletion action
     */
    protected function logDeletion($objet, $objet_id, $details = null)
    {
        $this->logAction('delete', $objet, $objet_id, $details ?? "{$objet} supprimé");
    }

    /**
     * Log a reservation action (approve, reject, etc.)
     */
    protected function logReservationAction($action, $reservation_id, $details = null)
    {
        $actionLabels = [
            'approve' => 'Réservation approuvée',
            'reject' => 'Réservation refusée',
            'cancel' => 'Réservation annulée',
            'activate' => 'Réservation activée',
            'complete' => 'Réservation terminée',
        ];

        $this->logAction(
            $action,
            'Reservation',
            $reservation_id,
            $details ?? ($actionLabels[$action] ?? $action)
        );
    }

    /**
     * Log a resource state change
     */
    protected function logRessourceStateChange($ressource_id, $old_state, $new_state, $details = null)
    {
        $this->logAction(
            'state_change',
            'Ressource',
            $ressource_id,
            $details ?? "État changé de {$old_state} à {$new_state}"
        );
    }
}
