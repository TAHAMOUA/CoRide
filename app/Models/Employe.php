<?php

namespace App\Models;

use App\Enums\RoleEmploye;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Un employe appartient a une seule entreprise et possede un email professionnel unique.
 * Il peut etre conducteur, passager, ou les deux selon les trajets (role).
 * Tache: Taha (Epic 3 - Creer le modele Employe / relations Eloquent)
 */
class Employe extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'employes';

    protected $fillable = [
        'nom',
        'email',
        'password',
        'entreprise_id',
        'ville_residence',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleEmploye::class,
        ];
    }

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    /**
     * Trajets proposes par cet employe en tant que conducteur.
     */
    public function trajetsProposes(): HasMany
    {
        return $this->hasMany(Trajet::class, 'conducteur_id');
    }

    /**
     * Reservations effectuees par cet employe en tant que passager.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'passager_id');
    }

    public function estConducteur(): bool
    {
        return $this->role->peutConduire();
    }

    public function estPassager(): bool
    {
        return $this->role->peutReserver();
    }

    public function isAdmin(): bool
    {
        return $this->email === env('CORIDE_ADMIN_EMAIL', 'admin@techrecrut.test');
    }
}
