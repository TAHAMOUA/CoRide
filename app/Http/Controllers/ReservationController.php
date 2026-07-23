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
        $reservations = Reservation::with(['trajet', 'employe'])->get();

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
        Reservation::create($request->validated());

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Afficher une réservation.
     */
    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

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
        $reservation->update($request->validated());

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation mise à jour avec succès.');
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