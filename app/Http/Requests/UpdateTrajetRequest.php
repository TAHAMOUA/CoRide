<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Tache: Soukaina (Epic 3 - Creer les Form Requests)
 */
class UpdateTrajetRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Seul le conducteur proprietaire du trajet peut le modifier (voir TrajetPolicy).
        return $this->user()?->can('update', $this->route('trajet')) ?? false;
    }

    public function rules(): array
    {
        return [
            'ville_depart' => ['required', 'string', 'max:100'],
            'ville_arrivee' => ['required', 'string', 'max:100', 'different:ville_depart'],
            'horaire' => ['required', 'date'],
            'places_disponibles' => [
                'required',
                'integer',
                'min:1',
                'max:8',
                // On ne peut pas reduire les places sous le nombre de reservations deja confirmees.
                function ($attribute, $value, $fail) {
                    $trajet = $this->route('trajet');
                    if ($trajet && $value < $trajet->reservationsConfirmees()->count()) {
                        $fail('Le nombre de places ne peut pas etre inferieur aux reservations deja confirmees.');
                    }
                },
            ],
            'jours_recurrence' => ['nullable', 'array'],
            'jours_recurrence.*' => ['string', 'in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche'],
        ];
    }
}
