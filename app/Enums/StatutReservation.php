<?php

namespace App\Enums;

/**
 * Statuts possibles d'une reservation et transitions autorisees.
 * Tache: Soukaina (Epic 3 - Gerer les statuts / Controler les transitions de statut)
 */
enum StatutReservation: string
{
    case EnAttente = 'en_attente';
    case Confirmee = 'confirmee';
    case Refusee = 'refusee';
    case Annulee = 'annulee';

    public function label(): string
    {
        return match ($this) {
            self::EnAttente => 'En attente',
            self::Confirmee => 'Confirmee',
            self::Refusee => 'Refusee',
            self::Annulee => 'Annulee',
        };
    }

    /**
     * Depuis cet etat, vers quels etats la transition est-elle autorisee ?
     */
    public function transitionsAutorisees(): array
    {
        return match ($this) {
            self::EnAttente => [self::Confirmee, self::Refusee, self::Annulee],
            self::Confirmee => [self::Annulee],
            self::Refusee => [],
            self::Annulee => [],
        };
    }

    public function peutTransitionnerVers(StatutReservation $cible): bool
    {
        return in_array($cible, $this->transitionsAutorisees(), true);
    }
}
