<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $table = 'employes';

    protected $primaryKey = 'id_employe';

    protected $fillable = [
        'nom',
        'email_professionnel',
        'ville_residence',
        'role',
        'id_entreprise',
    ];

    /**
     * Un employé appartient à une entreprise.
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }

    /**
     * Un employé (conducteur) peut proposer plusieurs trajets.
     */
    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'id_employe', 'id_employe');
    }

    /**
     * Un employé (passager) peut effectuer plusieurs réservations.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_employe', 'id_employe');
    }
}