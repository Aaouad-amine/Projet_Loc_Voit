<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom', 'prenom', 'email', 'phone', 'password', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    // Un locataire a plusieurs voitures
    // Relation pour le locataire
public function reservations()
{
    return $this->hasMany(Reservation::class);
}

// Relation pour le propriétaire/admin
public function voitures()
{
    return $this->hasMany(Voiture::class);
}
    public function factures()
{
    return $this->hasManyThrough(
        \App\Models\Facture::class,
        \App\Models\Reservation::class,
        'user_id',        // FK sur reservations
        'reservation_id'  // FK sur factures
    );
}

    // Helpers rôles
    public function isLocataire(): bool { return $this->role === 'locataire'; }
    public function isClient(): bool    { return $this->role === 'client'; }
    public function isAdmin(): bool     { return $this->role === 'admin'; }
}