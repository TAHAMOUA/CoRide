<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tache: Soukaina (Epic 2 - Creer les migrations)
// La colonne compatibilite_ia stocke le resultat IA (score, justification, horaire_suggere)
// au format JSON. Elle est manipulee via App\Casts\CompatibiliteIACast (Taha - Epic 5).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trajet_id')->constrained('trajets')->cascadeOnDelete();
            $table->foreignId('passager_id')->constrained('employes')->cascadeOnDelete();
            $table->string('statut')->default('en_attente'); // voir App\Enums\StatutReservation
            $table->dateTime('date_reservation')->useCurrent();
            $table->json('compatibilite_ia')->nullable();
            $table->timestamps();

            // Un meme employe ne peut pas reserver deux fois le meme trajet.
            $table->unique(['trajet_id', 'passager_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
