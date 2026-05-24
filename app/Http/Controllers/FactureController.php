<?php
namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    private function autoriser(Facture $facture): void
    {
        $user = Auth::user();
        $res  = $facture->reservation;

        $estAdmin        = $user->role === 'admin';
        $estLeClient     = $res->user_id === $user->id;
        $estLeProprietaire = $res->voiture->user_id === $user->id;

        if (!$estAdmin && !$estLeClient && !$estLeProprietaire) {
            abort(403);
        }
    }

    public function show(Facture $facture)
    {
        $facture->load('reservation.voiture', 'reservation.user');
        $this->autoriser($facture);
        return view('factures.show', compact('facture'));
    }

    public function download(Facture $facture)
    {
        $facture->load('reservation.voiture', 'reservation.user');
        $this->autoriser($facture);
        $pdf = Pdf::loadView('factures.pdf', compact('facture'));
        return $pdf->download("facture-{$facture->id}.pdf");
    }
}