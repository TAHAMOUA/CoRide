<?php

namespace App\ValueObjects;

/**
 * Represente le resultat structure renvoye par la brique IA :
 * un score de compatibilite, une justification textuelle et un horaire suggere.
 * Tache: Taha (Epic 5 - Creer le Cast personnalise)
 */
final readonly class CompatibiliteIA
{
    public function __construct(
        public int $score,
        public string $justification,
        public ?string $horaireSuggere = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            score: (int) ($data['score'] ?? 0),
            justification: (string) ($data['justification'] ?? ''),
            horaireSuggere: $data['horaire_suggere'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'score' => $this->score,
            'justification' => $this->justification,
            'horaire_suggere' => $this->horaireSuggere,
        ];
    }
}
