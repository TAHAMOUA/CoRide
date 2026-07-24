<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tache: Soukaina (Epic 2 - Creer les migrations)
// Remplace la table users par defaut de Breeze : un employe = un utilisateur CoRide.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('entreprise_id')->constrained('entreprises')->cascadeOnDelete();
            $table->string('ville_residence');
            $table->string('role'); // conducteur | passager | les_deux (voir App\Enums\RoleEmploye)
            $table->rememberToken();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('employes');
    }
};
