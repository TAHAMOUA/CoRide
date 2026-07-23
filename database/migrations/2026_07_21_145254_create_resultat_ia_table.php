<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resultat_ia', function (Blueprint $table) {

            $table->id('id_resultat');

            $table->integer('score_compatibilite');

            $table->text('justification');

            $table->dateTime('horaire_suggere')->nullable();

            $table->foreignId('id_reservation')
                ->constrained('reservations', 'id_reservation')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultat_ia');
    }
};