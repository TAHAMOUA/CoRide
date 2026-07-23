<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employe extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'employes';

    protected $primaryKey = 'id_employe';

    protected $fillable = [
        'nom',
        'email_professionnel',
        'password',
        'ville_residence',
        'role',
        'id_entreprise',
    ];

   
 
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }

    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'id_employe', 'id_employe');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_employe', 'id_employe');
    }
}