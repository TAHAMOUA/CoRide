<?php

namespace App\Http\Requests;

use App\Enums\StatutReservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * Tache: Soukaina (Epic 3 - Controler les transitions de statut)
 */
class UpdateReservationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $reservation = $this->route('reservation');
        $user = $this->user();

        // Le conducteur du trajet peut confirmer/refuser ; le passager peut annuler.
        return $user && (
            $reservation->trajet->conducteur_id === $user->id
            || $reservation->passager_id === $user->id
        );
    }

    public function rules(): array
    {
        return [
            'statut' => ['required', new Enum(StatutReservation::class)],
        ];
    }
}
