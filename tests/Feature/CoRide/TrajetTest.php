<?php

namespace Tests\Feature\CoRide;

use App\Enums\RoleEmploye;
use App\Enums\StatutReservation;
use App\Models\Employe;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Regles de gestion couvertes :
 * - un trajet est propose par un employe conducteur (role conducteur / les_deux)
 * - un trajet ne peut pas etre supprime s'il a des reservations confirmees
 * - le nombre de places ne peut pas descendre sous le nombre de reservations confirmees
 */
class TrajetTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_conducteur_peut_publier_un_trajet(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);

        $response = $this->actingAs($conducteur)->post('/trajets', [
            'ville_depart' => 'Casablanca',
            'ville_arrivee' => 'Rabat',
            'horaire' => now()->addDay()->format('Y-m-d H:i:s'),
            'places_disponibles' => 3,
            'jours_recurrence' => ['lundi', 'mercredi'],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('trajets', [
            'conducteur_id' => $conducteur->id,
            'ville_depart' => 'Casablanca',
            'ville_arrivee' => 'Rabat',
        ]);
    }

    public function test_un_passager_pur_ne_peut_pas_publier_un_trajet(): void
    {
        $passager = Employe::factory()->create(['role' => RoleEmploye::Passager]);

        $response = $this->actingAs($passager)->post('/trajets', [
            'ville_depart' => 'Casablanca',
            'ville_arrivee' => 'Rabat',
            'horaire' => now()->addDay()->format('Y-m-d H:i:s'),
            'places_disponibles' => 3,
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('trajets', 0);
    }

    public function test_ville_arrivee_doit_etre_differente_de_ville_depart(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);

        $response = $this->actingAs($conducteur)->post('/trajets', [
            'ville_depart' => 'Casablanca',
            'ville_arrivee' => 'Casablanca',
            'horaire' => now()->addDay()->format('Y-m-d H:i:s'),
            'places_disponibles' => 3,
        ]);

        $response->assertSessionHasErrors('ville_arrivee');
    }

    public function test_impossible_de_supprimer_un_trajet_avec_reservation_confirmee(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 2]);
        Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'statut' => StatutReservation::Confirmee->value,
        ]);

        $response = $this->actingAs($conducteur)->delete("/trajets/{$trajet->id}");

        $response->assertForbidden();
        $this->assertDatabaseHas('trajets', ['id' => $trajet->id]);
    }

    public function test_un_trajet_sans_reservation_confirmee_peut_etre_supprime(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id]);
        Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'statut' => StatutReservation::EnAttente->value,
        ]);

        $response = $this->actingAs($conducteur)->delete("/trajets/{$trajet->id}");

        $response->assertRedirect(route('trajets.index'));
        $this->assertDatabaseMissing('trajets', ['id' => $trajet->id]);
    }

    public function test_impossible_de_reduire_les_places_sous_le_nombre_de_reservations_confirmees(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 3]);
        Reservation::factory()->count(2)->create([
            'trajet_id' => $trajet->id,
            'statut' => StatutReservation::Confirmee->value,
        ]);

        $response = $this->actingAs($conducteur)->put("/trajets/{$trajet->id}", [
            'ville_depart' => $trajet->ville_depart,
            'ville_arrivee' => $trajet->ville_arrivee,
            'horaire' => $trajet->horaire->format('Y-m-d H:i:s'),
            'places_disponibles' => 1,
        ]);

        $response->assertSessionHasErrors('places_disponibles');
    }

    public function test_un_autre_employe_ne_peut_pas_modifier_le_trajet_dautrui(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $autre = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id]);

        $response = $this->actingAs($autre)->get("/trajets/{$trajet->id}/edit");

        $response->assertForbidden();
    }
}
