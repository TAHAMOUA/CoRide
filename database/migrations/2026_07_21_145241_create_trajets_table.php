<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trajets', function (Blueprint $table) {

            $table->id('id_trajet');

            $table->string('ville_depart');

            $table->string('ville_arrivee');

            $table->dateTime('horaire');

            $table->integer('places_disponibles');

            $table->string('jours_recurrence');

            $table->foreignId('id_employe')
                ->constrained('employes', 'id_employe')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};