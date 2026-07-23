<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {

            $table->id('id_reservation');

            $table->enum('statut', [
                'en_attente',
                'confirmee',
                'refusee',
                'annulee'
            ]);

            $table->date('date_reservation');

            $table->foreignId('id_trajet')
                ->constrained('trajets', 'id_trajet')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_employe')
                ->constrained('employes', 'id_employe')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();

            $table->unique(['id_trajet','id_employe']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};