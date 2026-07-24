<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Tache: Taha (Epic 3 - Creer le modele Entreprise)
class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function employes(): HasMany
    {
        return $this->hasMany(Employe::class);
    }
}
