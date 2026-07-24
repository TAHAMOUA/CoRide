<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Tache: Soukaina (Epic 3 - Creer les Form Requests)
 */
class StoreTrajetRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Seul un employe conducteur (ou "les_deux") peut publier un trajet.
        return $this->user()?->estConducteur() ?? false;
    }

    public function rules(): array
    {
        return [
            'ville_depart' => ['required', 'string', 'max:100'],
            'ville_arrivee' => ['required', 'string', 'max:100', 'different:ville_depart'],
            'horaire' => ['required', 'date', 'after:now'],
            'places_disponibles' => ['required', 'integer', 'min:1', 'max:8'],
            'jours_recurrence' => ['nullable', 'array'],
            'jours_recurrence.*' => ['string', 'in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche'],
        ];
    }

    public function messages(): array
    {
        return [
            'ville_arrivee.different' => "La ville d'arrivee doit etre differente de la ville de depart.",
            'horaire.after' => "L'horaire du trajet doit etre dans le futur.",
        ];
    }
}
