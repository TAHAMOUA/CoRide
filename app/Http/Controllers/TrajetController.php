<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrajetRequest;
use App\Http\Requests\UpdateTrajetRequest;
use App\Models\Trajet;
use App\Models\Employe;

class TrajetController extends Controller
{
    /**
     * Afficher la liste des trajets.
     */
    public function index()
    {
        $trajets = Trajet::with('employe')->get();

        return response()->json($trajets);
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        //
    }

    /**
     * Enregistrer un nouveau trajet.
     */
    public function store(StoreTrajetRequest $request)
    {
        $trajet = Trajet::create($request->validated());

        return response()->json([
            'message' => 'Trajet créé avec succès.',
            'data' => $trajet
        ], 201);
    }

    /**
     * Afficher un trajet.
     */
    public function show(Trajet $trajet)
    {
        return response()->json($trajet->load('employe'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Trajet $trajet)
    {
        //
    }

    /**
     * Modifier un trajet.
     */
    public function update(UpdateTrajetRequest $request, Trajet $trajet)
    {
        $trajet->update($request->validated());

        return response()->json([
            'message' => 'Trajet modifié avec succès.',
            'data' => $trajet
        ]);
    }

    /**
     * Supprimer un trajet.
     */
    public function destroy(Trajet $trajet)
    {
        $trajet->delete();

        return response()->json([
            'message' => 'Trajet supprimé avec succès.'
        ]);
    }
}