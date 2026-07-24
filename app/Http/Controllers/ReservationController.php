<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationStatusRequest;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Tache creation reservation: Taha (Epic 3 - Creer le contrôleur Reservation /
 *   Vérifier les places disponibles / Empêcher les réservations en doublon)
 * Tache gestion des statuts: Soukaina (Epic 3 - Gerer les statuts des reservations /
 *   Controler les transitions de statut)
 */
class ReservationController extends Controller
{
    /**
     * Un passager reserve un trajet (statut initial : en_attente).
     * Regle de gestion : pas plus de reservations confirmees que de places,
     * et un employe ne peut pas reserver deux fois le meme trajet.
     * Ces deux regles sont deja verifiees dans StoreReservationRequest.
     */
    public function store(StoreReservationRequest $request, Trajet $trajet): RedirectResponse
    {
        $reservation = Reservation::create([
            'trajet_id' => $trajet->id,
            'passager_id' => $request->user()->id,
            'statut' => 'en_attente',
            'date_reservation' => now(),
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('status', 'Demande de reservation envoyee (en attente de confirmation).');
    }

    /**
     * Page "Mes reservations" : historique des reservations du passager connecte.
     */
    public function index(Request $request): View
    {
        $reservations = $request->user()
            ->reservations()
            ->with(['trajet.conducteur'])
            ->orderByDesc('date_reservation')
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Changement de statut d'une reservation (confirmer/refuser par le
     * conducteur, ou annuler par le conducteur ou le passager).
     * La matrice de transitions autorisees est appliquee dans
     * Reservation::changerStatut() (App\Enums\StatutReservation).
     */
    public function updateStatus(UpdateReservationStatusRequest $request, Reservation $reservation): RedirectResponse
    {
        try {
            $reservation->changerStatut($request->enum('statut', \App\Enums\StatutReservation::class));
        } catch (\DomainException $e) {
            return back()->withErrors(['statut' => $e->getMessage()]);
        }

        return back()->with('status', 'Statut de la reservation mis a jour.');
    }
}
