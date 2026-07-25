<?php

namespace App\Http\Controllers;

use App\Enums\RoleEmploye;
use App\Enums\StatutReservation;
use App\Models\Entreprise;
use App\Models\Employe;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $utilisateurs = [
            'candidats' => Employe::whereIn('role', [RoleEmploye::Passager->value, RoleEmploye::LesDeux->value])->count(),
            'entreprises' => Entreprise::count(),
            'admins' => Employe::where('email', 'admin@techrecrut.test')->count(),
        ];

        $offres = [
            'total' => Trajet::count(),
            'actives' => Trajet::count(),
            'archivees' => 0,
        ];

        $statuses = Reservation::select('statut', DB::raw('count(*) as cnt'))
            ->groupBy('statut')
            ->pluck('cnt', 'statut')
            ->toArray();

        $candidatures = [
            'en_attente' => $statuses['en_attente'] ?? 0,
            'acceptee' => $statuses['confirmee'] ?? 0,
            'refusee' => $statuses['refusee'] ?? 0,
        ];

        return view('dashboard.index', compact('trajets', 'demandesEnAttente', 'utilisateurs', 'offres', 'candidatures'));
    }
}
