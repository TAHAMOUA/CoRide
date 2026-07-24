<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tache: Soukaina (Epic 2 - Creer les migrations)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conducteur_id')->constrained('employes')->cascadeOnDelete();
            $table->string('ville_depart');
            $table->string('ville_arrivee');
            $table->dateTime('horaire');
            $table->unsignedTinyInteger('places_disponibles');
            $table->json('jours_recurrence')->nullable(); // ex: ["lundi","mardi","jeudi"]
            $table->timestamps();

            $table->index(['ville_depart', 'ville_arrivee']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};
