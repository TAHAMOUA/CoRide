<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Tache: Soukaina (Epic 3 - Creer les Form Requests / Empecher les doublons)
 */
class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->estPassager() ?? false;
    }

    public function rules(): array
    {
        $trajet = $this->route('trajet');

        return [
            // Un meme employe ne peut pas reserver deux fois le meme trajet.
            'trajet_id' => [
                Rule::unique('reservations', 'trajet_id')
                    ->where('passager_id', $this->user()?->id)
                    ->ignore(null),
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $trajet = $this->route('trajet');

            if (! $trajet) {
                return;
            }

            if ($trajet->conducteur_id === $this->user()->id) {
                $validator->errors()->add('trajet_id', 'Vous ne pouvez pas reserver votre propre trajet.');
            }

            if (! $trajet->aDesPlacesDisponibles()) {
                $validator->errors()->add('trajet_id', 'Ce trajet est complet.');
            }

            $dejaReserve = Reservation::query()
                ->where('trajet_id', $trajet->id)
                ->where('passager_id', $this->user()->id)
                ->exists();

            if ($dejaReserve) {
                $validator->errors()->add('trajet_id', 'Vous avez deja reserve ce trajet.');
            }
        });
    }
}
