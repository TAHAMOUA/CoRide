<?php

namespace App\Casts;

use App\ValueObjects\CompatibiliteIA;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Garantit que la colonne `compatibilite_ia` est toujours lue/ecrite sous
 * la forme d'un objet CompatibiliteIA (score, justification, horaire_suggere),
 * jamais comme un tableau brut ou une chaine JSON non verifiee.
 *
 * Tache: Taha (Epic 5 - US8 - Utiliser un Cast pour stocker proprement la reponse IA)
 *
 * @implements CastsAttributes<CompatibiliteIA|null, CompatibiliteIA|array|null>
 */
class CompatibiliteIACast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?CompatibiliteIA
    {
        if ($value === null) {
            return null;
        }

        $decoded = is_string($value) ? json_decode($value, true) : $value;

        if (! is_array($decoded)) {
            return null;
        }

        return CompatibiliteIA::fromArray($decoded);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof CompatibiliteIA) {
            return json_encode($value->toArray());
        }

        if (is_array($value)) {
            return json_encode(CompatibiliteIA::fromArray($value)->toArray());
        }

        throw new \InvalidArgumentException('compatibilite_ia doit etre un CompatibiliteIA, un tableau ou null.');
    }
}
