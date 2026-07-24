<?php

namespace App\Http\Controllers;

use App\Enums\StatutReservation;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Tache: Soukaina (Epic 4 - Creer le tableau de bord conducteur)
 */
class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $trajets = $request->user()
            ->trajetsProposes()
            ->with(['reservations.passager'])
            ->orderBy('horaire')
            ->get();

        $demandesEnAttente = $trajets
            ->flatMap(fn ($trajet) => $trajet->reservations)
            ->filter(fn ($reservation) => $reservation->statut === StatutReservation::EnAttente);

        return view('dashboard.index', compact('trajets', 'demandesEnAttente'));
    }
}
