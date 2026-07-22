<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'id_trajet' => 'required|exists:trajets,id_trajet',
            'id_employe' => 'required|exists:employes,id_employe',
            'statut' => 'required|in:en_attente,confirmee,refusee,annulee',
        ];
    }

    public function messages(): array
    {
        return [
            'id_trajet.required' => 'Le trajet est obligatoire.',
            'id_trajet.exists' => 'Le trajet est introuvable.',
            'id_employe.required' => "L'employé est obligatoire.",
            'statut.in' => 'Le statut est invalide.',
        ];
    }
}
