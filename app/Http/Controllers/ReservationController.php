<?php
namespace App\Http\Controllers;

use App\Models\Voiture;
use App\Models\Reservation;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create(Voiture $voiture)
    {
        if (!$voiture->disponibilite) {
            return back()->withErrors(['voiture' => 'Cette voiture n\'est pas disponible.']);
        }
        return view('reservations.create', compact('voiture'));
    }

    public function store(Request $request, Voiture $voiture)
    {
        $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin'   => 'required|date|after:date_debut',
        ]);

        if (!$voiture->disponibilite) {
            return back()->withErrors(['voiture' => 'Voiture non disponible.']);
        }

        if (!$voiture->assuranceValide()) {
            return back()->withErrors(['assurance' => 'Assurance expirée. Réservation impossible.']);
        }

        // ✅ Calcul du montant corrigé
        $debut  = Carbon::parse($request->date_debut);
        $fin    = Carbon::parse($request->date_fin);
        $jours  = max(1, $debut->diffInDays($fin)); // minimum 1 jour

        // ✅ Adaptez selon votre colonne : prix_journalier OU prix_par_jour OU prix
        $prixParJour = $voiture->prix_journalier
                    ?? $voiture->prix_par_jour
                    ?? $voiture->prix
                    ?? 0;

        $montant = $jours * $prixParJour;

        // ✅ Créer réservation
        $reservation = Reservation::create([
            'voiture_id'    => $voiture->id,
            'user_id'       => Auth::id(),
            'date_debut'    => $request->date_debut,
            'date_fin'      => $request->date_fin,
            'statut'        => 'confirmee',
            'montant_total' => $montant,
        ]);

        // ✅ Marquer voiture indisponible
        $voiture->update(['disponibilite' => false]);

        // ✅ Générer facture automatiquement
        Facture::create([
            'reservation_id' => $reservation->id,
            'montant_total'  => $montant,
            'date_emission'  => now()->toDateString(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', "Réservation confirmée pour {$jours} jour(s) ! Montant : {$montant} MAD");
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }
        $reservation->update(['statut' => 'annulee']);
        $reservation->voiture->update(['disponibilite' => true]);
        return back()->with('success', 'Réservation annulée.');
    }

    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        // Admin voit TOUT
        $reservations = Reservation::with(['voiture', 'user'])
            ->latest()
            ->get();
    } elseif ($user->role === 'proprietaire') {
        // Propriétaire voit les réservations de ses voitures
        $reservations = Reservation::whereIn(
            'voiture_id',
            $user->voitures()->pluck('id')
        )->with(['voiture', 'user'])->latest()->get();
    } else {
        // ✅ Tout autre rôle (locataire, client, user, null...) = ses propres réservations
        $reservations = Reservation::where('user_id', $user->id)
            ->with('voiture')
            ->latest()
            ->get();
    }

    return view('reservations.index', compact('reservations'));
}

    public function cancel(Reservation $reservation)
    {
        // ✅ Admin ou propriétaire peut annuler
        $user = Auth::user();
        if ($user->role !== 'admin' && $reservation->voiture->user_id !== $user->id) {
            abort(403);
        }
        $reservation->update(['statut' => 'annulee']);
        $reservation->voiture->update(['disponibilite' => true]);
        return back()->with('success', 'Réservation annulée avec succès.');
    }
}