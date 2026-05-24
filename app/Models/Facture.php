<?php
// app/Models/Facture.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = ['reservation_id', 'montant_total', 'date_emission'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}