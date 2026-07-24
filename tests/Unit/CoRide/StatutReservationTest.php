<?php

namespace Tests\Unit\CoRide;

use App\Enums\StatutReservation;
use PHPUnit\Framework\TestCase;

/**
 * Regle de gestion : une reservation a un statut dont les transitions sont controlees.
 */
class StatutReservationTest extends TestCase
{
    public function test_en_attente_peut_transitionner_vers_confirmee_refusee_ou_annulee(): void
    {
        $this->assertTrue(StatutReservation::EnAttente->peutTransitionnerVers(StatutReservation::Confirmee));
        $this->assertTrue(StatutReservation::EnAttente->peutTransitionnerVers(StatutReservation::Refusee));
        $this->assertTrue(StatutReservation::EnAttente->peutTransitionnerVers(StatutReservation::Annulee));
    }

    public function test_confirmee_ne_peut_transitionner_que_vers_annulee(): void
    {
        $this->assertTrue(StatutReservation::Confirmee->peutTransitionnerVers(StatutReservation::Annulee));
        $this->assertFalse(StatutReservation::Confirmee->peutTransitionnerVers(StatutReservation::EnAttente));
        $this->assertFalse(StatutReservation::Confirmee->peutTransitionnerVers(StatutReservation::Refusee));
    }

    public function test_refusee_et_annulee_sont_des_etats_terminaux(): void
    {
        foreach (StatutReservation::cases() as $cible) {
            $this->assertFalse(StatutReservation::Refusee->peutTransitionnerVers($cible));
            $this->assertFalse(StatutReservation::Annulee->peutTransitionnerVers($cible));
        }
    }
}
