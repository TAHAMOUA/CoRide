<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $table = 'entreprises';

    protected $primaryKey = 'id_entreprise';

    protected $fillable = [
        'nom',
        'secteur',
        'adresse',
        'ville',
    ];

    /**
     * Une entreprise possède plusieurs employés.
     */
    public function employes()
    {
        return $this->hasMany(Employe::class, 'id_entreprise', 'id_entreprise');
    }
}