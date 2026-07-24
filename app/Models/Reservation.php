<?php

namespace App\Models;

use App\Casts\CompatibiliteIACast;
use App\Enums\StatutReservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Une reservation relie un employe passager a un trajet.
 * Tache modele: Taha (Epic 3) — Tache transitions de statut: Soukaina (Epic 3)
 */
class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trajet_id',
        'passager_id',
        'statut',
        'date_reservation',
        'compatibilite_ia',
    ];

    protected function casts(): array
    {
        return [
            'statut' => StatutReservation::class,
            'date_reservation' => 'datetime',
            'compatibilite_ia' => CompatibiliteIACast::class,
        ];
    }

    public function trajet(): BelongsTo
    {
        return $this->belongsTo(Trajet::class);
    }

    public function passager(): BelongsTo
    {
        return $this->belongsTo(Employe::class, 'passager_id');
    }

    /**
     * Applique une transition de statut en verifiant qu'elle est autorisee
     * par la matrice de StatutReservation. Leve une exception sinon.
     *
     * Tache: Soukaina (Epic 3 - Controler les transitions de statut)
     */
    public function changerStatut(StatutReservation $nouveauStatut): void
    {
        if (! $this->statut->peutTransitionnerVers($nouveauStatut)) {
            throw new \DomainException(sprintf(
                'Transition interdite : %s -> %s',
                $this->statut->value,
                $nouveauStatut->value
            ));
        }

        if ($nouveauStatut === StatutReservation::Confirmee && ! $this->trajet->aDesPlacesDisponibles()) {
            throw new \DomainException('Impossible de confirmer : plus de places disponibles sur ce trajet.');
        }

        $this->update(['statut' => $nouveauStatut]);
    }
}
