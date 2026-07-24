<?php

namespace App\Services;

use App\Ai\Agents\CompatibiliteAgent;
use App\Models\Employe;
use App\Models\Trajet;
use App\ValueObjects\CompatibiliteIA;

/**
 * Regle de gestion : le score de compatibilite IA est calcule a la demande
 * d'un passager cherchant un trajet, jamais cote conducteur. Ce service ne
 * doit donc etre appele que depuis un contexte "recherche passager"
 * (voir TrajetController::show / index).
 *
 * Tache: Taha (Epic 5 - Creer le service de compatibilite IA)
 */
class CompatibiliteIAService
{
    public function __construct(
        private readonly CompatibiliteAgent $agent = new CompatibiliteAgent(),
    ) {
    }

    public function evaluer(Employe $passager, Trajet $trajet, ?string $horaireSouhaite = null): CompatibiliteIA
    {
        $prompt = $this->construirePrompt($passager, $trajet, $horaireSouhaite);

        $reponse = $this->agent->prompt($prompt);

        return CompatibiliteIA::fromArray([
            'score' => $reponse['score'],
            'justification' => $reponse['justification'],
            'horaire_suggere' => $reponse['horaire_suggere'] ?? null,
        ]);
    }

    private function construirePrompt(Employe $passager, Trajet $trajet, ?string $horaireSouhaite): string
    {
        $jours = $trajet->jours_recurrence ? implode(', ', $trajet->jours_recurrence) : 'non precise';

        return sprintf(
            "Passager :\n- Ville de residence : %s\n- Horaire souhaite : %s\n\n".
            "Trajet propose :\n- Depart : %s\n- Arrivee : %s\n- Horaire : %s\n- Jours de recurrence : %s\n- Places restantes : %d\n\n".
            'Evalue la compatibilite de ce trajet pour ce passager.',
            $passager->ville_residence,
            $horaireSouhaite ?? 'non precise',
            $trajet->ville_depart,
            $trajet->ville_arrivee,
            $trajet->horaire->format('H:i'),
            $jours,
            $trajet->placesRestantes(),
        );
    }
}
