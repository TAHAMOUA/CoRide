<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultatIA extends Model
{
    use HasFactory;

    protected $table = 'resultat_ia';

    protected $primaryKey = 'id_resultat';

    protected $fillable = [
        'score_compatibilite',
        'justification',
        'horaire_suggere',
        'id_reservation',
    ];

    /**
     * Un résultat IA appartient à une réservation.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'id_reservation', 'id_reservation');
    }
    public function resultatIA()
{
    return $this->hasOne(ResultatIA::class, 'id_reservation', 'id_reservation');
}
}