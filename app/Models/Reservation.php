<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $primaryKey = 'id_reservation';

    protected $fillable = [
        'statut',
        'date_reservation',
        'id_trajet',
        'id_employe',
    ];

    /**
     * Une réservation appartient à un trajet.
     */
    public function trajet()
    {
        return $this->belongsTo(Trajet::class, 'id_trajet', 'id_trajet');
    }

    /**
     * Une réservation appartient à un employé.
     */
    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe', 'id_employe');
    }

    /**
     * Une réservation possède un seul résultat IA.
     */
    public function resultatIA()
    {
        return $this->hasOne(ResultatIA::class, 'id_reservation', 'id_reservation');
    }
}