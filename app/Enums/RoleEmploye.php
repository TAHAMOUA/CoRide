<?php

namespace App\Enums;

/**
 * Role d'un employe dans CoRide.
 * Tache: Taha (Epic 2 - Identifier les entites / Modele Employe)
 */
enum RoleEmploye: string
{
    case Conducteur = 'conducteur';
    case Passager = 'passager';
    case LesDeux = 'les_deux';

    public function peutConduire(): bool
    {
        return in_array($this, [self::Conducteur, self::LesDeux], true);
    }

    public function peutReserver(): bool
    {
        return in_array($this, [self::Passager, self::LesDeux], true);
    }

    public function label(): string
    {
        return match ($this) {
            self::Conducteur => 'Conducteur',
            self::Passager => 'Passager',
            self::LesDeux => 'Conducteur & Passager',
        };
    }
}
