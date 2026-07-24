<?php

namespace App\Policies;

use App\Models\Employe;
use App\Models\Reservation;

/**
 * Tache: Soukaina (Epic 4 - Verifier la securite)
 */
class ReservationPolicy
{
    public function updateStatus(Employe $employe, Reservation $reservation): bool
    {
        return $employe->id === $reservation->trajet->conducteur_id
            || $employe->id === $reservation->passager_id;
    }

    public function view(Employe $employe, Reservation $reservation): bool
    {
        return $employe->id === $reservation->passager_id
            || $employe->id === $reservation->trajet->conducteur_id;
    }
}
