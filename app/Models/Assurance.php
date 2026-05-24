<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assurance extends Model
{
    protected $fillable = [
        'voiture_id', 'type_assurance', 'numero_police', 'date_debut', 'date_fin',
    ];

    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

    // Vérifier validité
    public function estValide(): bool
    {
        return $this->date_fin >= now()->toDateString();
    }
}