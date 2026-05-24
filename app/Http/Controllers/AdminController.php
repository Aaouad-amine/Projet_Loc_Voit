<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\{User, Voiture, Reservation, Facture};
use Illuminate\Http\Request;
class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'totalUsers'       => User::count(),
            'totalVoitures'    => Voiture::count(),
            'totalReservations'=> Reservation::count(),
            'totalRevenus'     => Facture::sum('montant_total'),
            'users'            => User::latest()->get(),
            'voitures'         => Voiture::with('user','assurance')->latest()->get(),
            'reservations'     => Reservation::with('voiture','user')->latest()->get(),
            'factures'         => Facture::with('reservation.voiture','reservation.user')->latest()->get(),
        ]);
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    public function deleteVoiture(Voiture $voiture)
    {
        $voiture->delete();
        return back()->with('success', 'Voiture supprimée.');
    }

    public function cancelReservation(Reservation $reservation)
    {
        $reservation->update(['statut' => 'annulee']);
        $reservation->voiture->update(['disponibilite' => true]);
        return back()->with('success', 'Réservation annulée.');
    }
}

