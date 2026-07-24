<?php

namespace App\Providers;

use App\Models\Reservation;
use App\Models\Trajet;
use App\Policies\ReservationPolicy;
use App\Policies\TrajetPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

/**
 * Tache: Soukaina (Epic 4 - Verifier la securite)
 */
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Trajet::class, TrajetPolicy::class);
        Gate::policy(Reservation::class, ReservationPolicy::class);
    }
}
