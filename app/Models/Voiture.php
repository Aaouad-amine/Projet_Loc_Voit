<?php
// app/Models/Voiture.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{
    protected $fillable = [
    'marque',
    'modele', 
    'annee',
    'prix_par_jour',   // ✅ doit correspondre à la colonne en base
    'disponibilite',
    'image',
    'user_id',
];

    protected $casts = ['disponibilite' => 'boolean'];

    // Propriétaire (locataire)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une voiture a une assurance
    public function assurance()
    {
        return $this->hasOne(Assurance::class);
    }

    // Une voiture a plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Vérifier si l'assurance est valide
    public function assuranceValide(): bool
    {
        return $this->assurance && $this->assurance->date_fin >= now()->toDateString();
    }
}