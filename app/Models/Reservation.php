<?php
// app/Models/Reservation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'voiture_id', 'user_id', 'date_debut', 'date_fin', 'statut', 'montant_total',
    ];
    
    public function client()
{
    return $this->belongsTo(User::class, 'user_id');
}
    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

    // Calculer le nombre de jours
    public function nombreJours(): int
    {
        return \Carbon\Carbon::parse($this->date_debut)
                             ->diffInDays($this->date_fin);
    }
}