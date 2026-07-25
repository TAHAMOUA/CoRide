<?php

namespace App\Http\Controllers;

use App\Enums\RoleEmploye;
use App\Models\Entreprise;
use App\Models\Employe;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function statistiques(): JsonResponse
    {
        $user = Auth::user();

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Accès refusé.');
        }

        // Utilisateurs par rôle
        $candidatsCount = Employe::whereIn('role', [RoleEmploye::Passager->value, RoleEmploye::LesDeux->value])->count();
        $entreprisesCount = Entreprise::count();
        $adminsCount = Employe::where('email', env('CORIDE_ADMIN_EMAIL', 'admin@techrecrut.test'))->count();

        // Offres (trajets) : gérer présence d'un soft delete éventuel
        $trajetsTotal = Trajet::count();
        $trajetsArchived = 0;
        if (Schema::hasColumn('trajets', 'deleted_at')) {
            $trajetsArchived = Trajet::withTrashed()->count() - Trajet::count();
        }
        $trajetsActive = $trajetsTotal;

        // Candidatures (reservations) par statut
        $statuses = Reservation::select('statut', DB::raw('count(*) as cnt'))
            ->groupBy('statut')
            ->pluck('cnt', 'statut')
            ->toArray();

        $candidatures = [
            'en_attente' => isset($statuses['en_attente']) ? (int) $statuses['en_attente'] : 0,
            'acceptee' => isset($statuses['confirmee']) ? (int) $statuses['confirmee'] : 0,
            'refusee' => isset($statuses['refusee']) ? (int) $statuses['refusee'] : 0,
        ];

        $payload = [
            'utilisateurs' => [
                'candidats' => $candidatsCount,
                'entreprises' => $entreprisesCount,
                'admins' => $adminsCount,
            ],
            'offres' => [
                'total' => $trajetsTotal,
                'actives' => $trajetsActive,
                'archivees' => $trajetsArchived,
            ],
            'candidatures' => $candidatures,
            'entreprises_actives' => $entreprisesCount,
        ];

        return response()->json($payload);
    }
}
