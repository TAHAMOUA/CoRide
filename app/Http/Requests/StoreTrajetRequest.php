<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrajetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                     'ville_depart' => 'required|string|max:100',
            'ville_arrivee' => 'required|string|max:100',
            'horaire' => 'required|date',
            'places_disponibles' => 'required|integer|min:1',
            'jours_recurrence' => 'required|string|max:255',
            'id_employe' => 'required|exists:employes,id_employe',
        ];
    }
public function messages(): array
    {
        return [
            'ville_depart.required' => 'La ville de départ est obligatoire.',
            'ville_arrivee.required' => 'La ville d’arrivée est obligatoire.',
            'horaire.required' => "L'horaire est obligatoire.",
            'places_disponibles.min' => 'Le trajet doit avoir au moins une place disponible.',
            'id_employe.exists' => 'Le conducteur sélectionné est invalide.',
        ];
    }
}
