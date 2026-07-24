<?php

namespace App\Models;

use App\Enums\StatutReservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Un trajet est propose par un employe conducteur.
 * Tache: Taha (Epic 3 - Creer le modele Trajet + relations)
 */
class Trajet extends Model
{
    use HasFactory;

    protected $fillable = [
        'conducteur_id',
        'ville_depart',
        'ville_arrivee',
        'horaire',
        'places_disponibles',
        'jours_recurrence',
    ];

    protected function casts(): array
    {
        return [
            'horaire' => 'datetime',
            'jours_recurrence' => 'array',
            'places_disponibles' => 'integer',
        ];
    }

    public function conducteur(): BelongsTo
    {
        return $this->belongsTo(Employe::class, 'conducteur_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function reservationsConfirmees(): HasMany
    {
        return $this->reservations()->where('statut', StatutReservation::Confirmee->value);
    }

    /**
     * Regle de gestion : un trajet ne peut pas avoir plus de reservations
     * validees (confirmees) que de places disponibles.
     */
    public function placesRestantes(): int
    {
        return max(0, $this->places_disponibles - $this->reservationsConfirmees()->count());
    }

    public function aDesPlacesDisponibles(): bool
    {
        return $this->placesRestantes() > 0;
    }

    /**
     * Regle de gestion : un trajet ne peut pas etre supprime s'il a des
     * reservations confirmees.
     */
    public function peutEtreSupprime(): bool
    {
        return $this->reservationsConfirmees()->doesntExist();
    }
}
