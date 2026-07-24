<?php

namespace App\Policies;

use App\Models\Employe;
use App\Models\Trajet;

/**
 * Tache: Soukaina (Epic 4 - Verifier la securite)
 */
class TrajetPolicy
{
    public function update(Employe $employe, Trajet $trajet): bool
    {
        return $employe->id === $trajet->conducteur_id;
    }

    public function delete(Employe $employe, Trajet $trajet): bool
    {
        return $employe->id === $trajet->conducteur_id && $trajet->peutEtreSupprime();
    }
}
