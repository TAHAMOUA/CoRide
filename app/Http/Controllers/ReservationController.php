<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\Employe;

class ReservationController extends Controller
{
    /**
     * Afficher la liste des réservations.
     */
    public function index()
    {
Reservation::with(['trajet','employe'])
    ->latest()
    ->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        $trajets = Trajet::all();
        $employes = Employe::all();

        return view('reservations.create', compact('trajets', 'employes'));
    }

    /**
     * Enregistrer une réservation.
     */
   public function store(StoreReservationRequest $request)
{
    $trajet = Trajet::findOrFail($request->id_trajet);

   $reservationsConfirmees = $trajet->reservations()
    ->where('statut', 'confirmee')
    ->count();

if ($reservationsConfirmees >= $trajet->places_disponibles) {
    return redirect()
        ->back()
        ->withInput()
        ->with('error', 'Ce trajet est complet.');
}
    $reservationExiste = Reservation::where('id_trajet', $request->id_trajet)
        ->where('id_employe', $request->id_employe)
        ->exists();

    if ($reservationExiste) {

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Vous avez déjà réservé ce trajet.');
    }

    
    $data = $request->validated();

$data['statut'] = 'en_attente';
$data['date_reservation'] = now();
Reservation::create($data);

    return redirect()
        ->route('reservations.index')
        ->with('success', 'Réservation créée avec succès.');
}

    /**
     * Afficher une réservation.
     */
    public function show(Reservation $reservation)
    {
$reservation->load(['trajet', 'employe']);

return view('reservations.show', compact('reservation'));    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Reservation $reservation)
    {
        $trajets = Trajet::all();
        $employes = Employe::all();

        return view('reservations.edit', compact('reservation', 'trajets', 'employes'));
    }

    /**
     * Mettre à jour une réservation.
     */
  
public function update(UpdateReservationRequest $request, Reservation $reservation)
{
    $ancienStatut = $reservation->statut;
    $nouveauStatut = $request->statut;

    $transitions = [
        'en_attente' => ['confirmee', 'refusee'],
        'confirmee' => ['annulee'],
        'refusee' => ['annulee'],
        'annulee' => [],
    ];

    if (
    !isset($transitions[$ancienStatut]) ||
    !in_array($nouveauStatut, $transitions[$ancienStatut])
) {
    return redirect()
        ->back()
        ->with('error', 'Transition de statut non autorisée.');
}
// Vérifier les places disponibles avant la confirmation
if ($nouveauStatut === 'confirmee') {

    $trajet = $reservation->trajet;

    $reservationsConfirmees = $trajet->reservations()
        ->where('statut', 'confirmee')
        ->count();

    if ($reservationsConfirmees >= $trajet->places_disponibles) {

        return redirect()
            ->back()
            ->with('error', 'Ce trajet est complet.');
    }
}
    $reservation->update([
        'statut' => $nouveauStatut,
    ]);

    return redirect()
        ->route('reservations.index')
        ->with('success', 'Statut de la réservation mis à jour.');
}

    /**
     * Supprimer une réservation.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation supprimée avec succès.');
    }
}