<?php

namespace Tests\Unit\CoRide;

use App\Casts\CompatibiliteIACast;
use App\Models\Reservation;
use App\ValueObjects\CompatibiliteIA;
use PHPUnit\Framework\TestCase;

/**
 * Regle de gestion (US8) : la reponse IA (score, justification, horaire_suggere)
 * est toujours manipulee via le Cast comme un objet CompatibiliteIA typé, jamais
 * comme un tableau brut ou une chaine JSON non verifiee.
 */
class CompatibiliteIACastTest extends TestCase
{
    public function test_get_retourne_null_quand_la_colonne_est_vide(): void
    {
        $cast = new CompatibiliteIACast();

        $this->assertNull($cast->get(new Reservation(), 'compatibilite_ia', null, []));
    }

    public function test_get_decode_le_json_stocke_en_objet_compatibiliteia(): void
    {
        $cast = new CompatibiliteIACast();
        $json = json_encode([
            'score' => 82,
            'justification' => 'Villes proches, horaires compatibles.',
            'horaire_suggere' => '08:15',
        ]);

        $resultat = $cast->get(new Reservation(), 'compatibilite_ia', $json, []);

        $this->assertInstanceOf(CompatibiliteIA::class, $resultat);
        $this->assertSame(82, $resultat->score);
        $this->assertSame('Villes proches, horaires compatibles.', $resultat->justification);
        $this->assertSame('08:15', $resultat->horaireSuggere);
    }

    public function test_set_accepte_un_objet_compatibiliteia_et_serialise_en_json(): void
    {
        $cast = new CompatibiliteIACast();
        $objet = new CompatibiliteIA(score: 40, justification: 'Horaires trop eloignes.', horaireSuggere: null);

        $stocke = $cast->set(new Reservation(), 'compatibilite_ia', $objet, []);

        $this->assertJsonStringEqualsJsonString(
            json_encode(['score' => 40, 'justification' => 'Horaires trop eloignes.', 'horaire_suggere' => null]),
            $stocke
        );
    }

    public function test_set_rejette_une_valeur_invalide(): void
    {
        $cast = new CompatibiliteIACast();

        $this->expectException(\InvalidArgumentException::class);
        $cast->set(new Reservation(), 'compatibilite_ia', 'texte-libre-non-structure', []);
    }

    public function test_round_trip_get_apres_set_conserve_les_donnees(): void
    {
        $cast = new CompatibiliteIACast();
        $objet = new CompatibiliteIA(score: 75, justification: 'Bonne compatibilite.', horaireSuggere: '18:00');

        $json = $cast->set(new Reservation(), 'compatibilite_ia', $objet, []);
        $recharge = $cast->get(new Reservation(), 'compatibilite_ia', $json, []);

        $this->assertEquals($objet, $recharge);
    }
}
