<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;

/**
 * Agent charge d'evaluer la compatibilite entre un passager et un trajet.
 * Retourne une sortie structuree (score, justification, horaire suggere)
 * plutot qu'un simple texte libre, afin d'etre stockee via le Cast IA.
 *
 * Tache: Taha (Epic 5 - Installer Laravel AI / Creer le service de compatibilite IA)
 * Tache Structured Output: Soukaina (Epic 5 - Implementer le Structured Output)
 */
class CompatibiliteAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): string
    {
        return <<<'TXT'
            Tu es l'assistant de covoiturage de CoRide. Tu evalues la compatibilite
            entre le trajet propose par un conducteur et la recherche d'un passager.

            Tu dois considerer :
            - la proximite reelle entre la ville de residence du passager et
              l'itineraire (ville de depart / ville d'arrivee) du trajet,
            - la coherence des horaires (l'heure du trajet est-elle exploitable
              pour le passager, ou trop eloignee de ce qu'il recherche ?),
            - les jours de recurrence du trajet par rapport au besoin du passager.

            Donne un score de compatibilite entre 0 et 100, une justification
            courte et concrete (pas de generalites), et si pertinent un horaire
            suggere qui rapprocherait davantage le trajet du besoin du passager.
            Reste factuel : si les villes ou horaires sont incompatibles, le
            score doit etre bas et la justification doit l'expliquer clairement.
            TXT;
    }

    /**
     * Definit le schema JSON de la reponse attendue de l'IA.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'score' => $schema->integer()
                ->description('Score de compatibilite entre 0 et 100')
                ->required(),
            'justification' => $schema->string()
                ->description('Explication concrete du score, en francais, 1 a 3 phrases')
                ->required(),
            'horaire_suggere' => $schema->string()
                ->description('Horaire alternatif suggere au format HH:MM, ou null si le trajet convient tel quel')
                ->nullable()
                ->required(),
        ];
    }
}