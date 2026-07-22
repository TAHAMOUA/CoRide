<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trajet extends Model
{
    use HasFactory;

    protected $table = 'trajets';

    protected $primaryKey = 'id_trajet';

    protected $fillable = [
        'ville_depart',
        'ville_arrivee',
        'horaire',
        'places_disponibles',
        'jours_recurrence',
        'id_employe',
    ];

    /**
     * Un trajet appartient à un employé (conducteur).
     */
    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe', 'id_employe');
    }

    /**
     * Un trajet possède plusieurs réservations.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_trajet', 'id_trajet');
    }
}