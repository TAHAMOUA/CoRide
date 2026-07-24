<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrajetRequest;
use App\Http\Requests\UpdateTrajetRequest;
use App\Models\Trajet;
use App\Services\CompatibiliteIAService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Tache CRUD: Soukaina (Epic 3 - Implementer le CRUD des trajets)
 * Tache recherche/detail: Taha (Epic 4 - Creer la liste des trajets / page detail)
 */
class TrajetController extends Controller
{
    /**
     * Liste des trajets, avec filtre simple ville depart/arrivee.
     * Le score IA n'est PAS calcule ici automatiquement (couteux) : le passager
     * le declenche a la demande depuis la page de detail (voir show()).
     */
    public function index(Request $request): View
    {
        $trajets = Trajet::query()
            ->with('conducteur')
            ->when($request->filled('ville_depart'), fn ($q) => $q->where('ville_depart', 'like', '%'.$request->string('ville_depart').'%'))
            ->when($request->filled('ville_arrivee'), fn ($q) => $q->where('ville_arrivee', 'like', '%'.$request->string('ville_arrivee').'%'))
            ->orderBy('horaire')
            ->paginate(10)
            ->withQueryString();

        return view('trajets.index', compact('trajets'));
    }

    public function create(): View
    {
        return view('trajets.create');
    }

    public function store(StoreTrajetRequest $request): RedirectResponse
    {
        $trajet = $request->user()->trajetsProposes()->create($request->validated());

        return redirect()
            ->route('trajets.show', $trajet)
            ->with('status', 'Trajet publie avec succes.');
    }

    /**
     * Regle de gestion : le score de compatibilite IA est calcule a la demande
     * d'un passager cherchant un trajet, jamais cote conducteur.
     */
    public function show(Request $request, Trajet $trajet, CompatibiliteIAService $ia): View
    {
        $trajet->load(['conducteur', 'reservations']);

        $compatibilite = null;
        $erreurIA = null;
        $user = $request->user();

        $estConducteurDuTrajet = $user && $user->id === $trajet->conducteur_id;

        if ($request->boolean('evaluer') && $user && $user->estPassager() && ! $estConducteurDuTrajet) {
            try {
                $compatibilite = $ia->evaluer($user, $trajet, $request->string('horaire_souhaite')->toString() ?: null);
            } catch (\Throwable $e) {
                report($e);
                $erreurIA = 'Le calcul de compatibilite IA a echoue. Verifiez la configuration du provider IA (.env) puis reessayez.';
            }
        }

        return view('trajets.show', compact('trajet', 'compatibilite', 'estConducteurDuTrajet', 'erreurIA'));
    }

    public function edit(Trajet $trajet): View
    {
        $this->authorize('update', $trajet);

        return view('trajets.edit', compact('trajet'));
    }

    public function update(UpdateTrajetRequest $request, Trajet $trajet): RedirectResponse
    {
        $trajet->update($request->validated());

        return redirect()->route('trajets.show', $trajet)->with('status', 'Trajet mis a jour.');
    }

    /**
     * Regle de gestion : un trajet ne peut pas etre supprime s'il a des
     * reservations confirmees.
     */
    public function destroy(Trajet $trajet): RedirectResponse
    {
        $this->authorize('delete', $trajet);

        if (! $trajet->peutEtreSupprime()) {
            return back()->withErrors([
                'trajet' => 'Impossible de supprimer un trajet ayant des reservations confirmees.',
            ]);
        }

        $trajet->delete();

        return redirect()->route('trajets.index')->with('status', 'Trajet supprime.');
    }
}