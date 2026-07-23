<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrajetRequest;
use App\Http\Requests\UpdateTrajetRequest;
use App\Models\Employe;
use App\Models\Trajet;

class TrajetController extends Controller
{
    /**
     * Afficher la liste des trajets.
     */
    public function index()
    {
        $trajets = Trajet::with('employe')->get();

        return view('trajets.index', compact('trajets'));
    }

    /**
     * Afficher le formulaire de création d'un trajet.
     */
    public function create()
    {
        $employes = Employe::all();

        return view('trajets.create', compact('employes'));
    }

    /**
     * Enregistrer un nouveau trajet.
     */
    public function store(StoreTrajetRequest $request)
    {
        Trajet::create($request->validated());

        return redirect()
            ->route('trajets.index')
            ->with('success', 'Trajet créé avec succès.');
    }

    /**
     * Afficher les détails d'un trajet.
     */
    public function show(Trajet $trajet)
    {
        return view('trajets.show', compact('trajet'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Trajet $trajet)
    {
        $employes = Employe::all();

        return view('trajets.edit', compact('trajet', 'employes'));
    }

    /**
     * Mettre à jour un trajet.
     */
    public function update(UpdateTrajetRequest $request, Trajet $trajet)
    {
        $trajet->update($request->validated());

        return redirect()
            ->route('trajets.index')
            ->with('success', 'Trajet mis à jour avec succès.');
    }

    /**
     * Supprimer un trajet.
     */
    public function destroy(Trajet $trajet)
    {
        $trajet->delete();

        return redirect()
            ->route('trajets.index')
            ->with('success', 'Trajet supprimé avec succès.');
    }
}