<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employes', function (Blueprint $table) {

            $table->id('id_employe');

            $table->string('nom');

            $table->string('email_professionnel')->unique();

            $table->string('ville_residence');

            $table->enum('role', [
                'conducteur',
                'passager',
                'les_deux'
            ]);

            $table->foreignId('id_entreprise')
                ->constrained('entreprises', 'id_entreprise')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};