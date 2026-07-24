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
 * - un trajet ne peut pas avoir plus de reservations validees que de places disponibles
 * - un meme employe ne peut pas reserver deux fois le meme trajet
 * - les transitions de statut d'une reservation sont controlees
 */
class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_passager_peut_reserver_un_trajet_disponible(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $passager = Employe::factory()->create(['role' => RoleEmploye::Passager]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 2]);

        $response = $this->actingAs($passager)->post("/trajets/{$trajet->id}/reserver");

        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseHas('reservations', [
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => StatutReservation::EnAttente->value,
        ]);
    }

    public function test_un_employe_ne_peut_pas_reserver_deux_fois_le_meme_trajet(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $passager = Employe::factory()->create(['role' => RoleEmploye::Passager]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 2]);
        Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => StatutReservation::EnAttente->value,
        ]);

        $response = $this->actingAs($passager)->post("/trajets/{$trajet->id}/reserver");

        $response->assertSessionHasErrors('trajet_id');
        $this->assertDatabaseCount('reservations', 1);
    }

    public function test_impossible_de_reserver_un_trajet_complet(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 1]);
        Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'statut' => StatutReservation::Confirmee->value,
        ]);

        $nouveauPassager = Employe::factory()->create(['role' => RoleEmploye::Passager]);

        $response = $this->actingAs($nouveauPassager)->post("/trajets/{$trajet->id}/reserver");

        $response->assertSessionHasErrors('trajet_id');
        $this->assertDatabaseCount('reservations', 1);
    }

    public function test_un_conducteur_ne_peut_pas_reserver_son_propre_trajet(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::LesDeux]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 2]);

        $response = $this->actingAs($conducteur)->post("/trajets/{$trajet->id}/reserver");

        $response->assertSessionHasErrors('trajet_id');
        $this->assertDatabaseCount('reservations', 0);
    }

    public function test_le_conducteur_peut_confirmer_une_reservation_en_attente(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 2]);
        $reservation = Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'statut' => StatutReservation::EnAttente->value,
        ]);

        $response = $this->actingAs($conducteur)->patch("/reservations/{$reservation->id}/statut", [
            'statut' => StatutReservation::Confirmee->value,
        ]);

        $response->assertRedirect();
        $this->assertSame(StatutReservation::Confirmee, $reservation->fresh()->statut);
    }

    public function test_impossible_de_confirmer_au_dela_des_places_disponibles(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 1]);

        Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'statut' => StatutReservation::Confirmee->value,
        ]);
        $enAttente = Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'statut' => StatutReservation::EnAttente->value,
        ]);

        $response = $this->actingAs($conducteur)->patch("/reservations/{$enAttente->id}/statut", [
            'statut' => StatutReservation::Confirmee->value,
        ]);

        $response->assertSessionHasErrors('statut');
        $this->assertSame(StatutReservation::EnAttente, $enAttente->fresh()->statut);
    }

    public function test_une_transition_de_statut_interdite_est_rejetee(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 2]);
        $reservation = Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'statut' => StatutReservation::Refusee->value,
        ]);

        // Une reservation refusee est un etat terminal : aucune transition n'est autorisee.
        $response = $this->actingAs($conducteur)->patch("/reservations/{$reservation->id}/statut", [
            'statut' => StatutReservation::Confirmee->value,
        ]);

        $response->assertSessionHasErrors('statut');
        $this->assertSame(StatutReservation::Refusee, $reservation->fresh()->statut);
    }

    public function test_un_passager_peut_annuler_sa_propre_reservation_confirmee(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $passager = Employe::factory()->create(['role' => RoleEmploye::Passager]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 2]);
        $reservation = Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => StatutReservation::Confirmee->value,
        ]);

        $response = $this->actingAs($passager)->patch("/reservations/{$reservation->id}/statut", [
            'statut' => StatutReservation::Annulee->value,
        ]);

        $response->assertRedirect();
        $this->assertSame(StatutReservation::Annulee, $reservation->fresh()->statut);
    }

    public function test_un_employe_etranger_a_la_reservation_ne_peut_pas_en_changer_le_statut(): void
    {
        $conducteur = Employe::factory()->create(['role' => RoleEmploye::Conducteur]);
        $trajet = Trajet::factory()->create(['conducteur_id' => $conducteur->id, 'places_disponibles' => 2]);
        $reservation = Reservation::factory()->create([
            'trajet_id' => $trajet->id,
            'statut' => StatutReservation::EnAttente->value,
        ]);

        $intrus = Employe::factory()->create(['role' => RoleEmploye::Passager]);

        $response = $this->actingAs($intrus)->patch("/reservations/{$reservation->id}/statut", [
            'statut' => StatutReservation::Confirmee->value,
        ]);

        $response->assertForbidden();
        $this->assertSame(StatutReservation::EnAttente, $reservation->fresh()->statut);
    }
}
