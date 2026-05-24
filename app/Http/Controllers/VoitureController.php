<?php
namespace App\Http\Controllers;

use App\Models\Voiture;
use App\Models\Assurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoitureController extends Controller
{
    // ─── Liste des voitures ───────────────────────────────────
    public function index()
    {
        $voitures = Voiture::with('assurance')->latest()->get();
        return view('voitures.index', compact('voitures'));
    }

    // ─── Détail d'une voiture ─────────────────────────────────
    public function show(Voiture $voiture)
    {
        $voiture->load('assurance');
        return view('voitures.show', compact('voiture'));
    }

    // ─── Formulaire création ──────────────────────────────────
    public function create()
    {
        return view('voitures.create');
    }

    // ─── Enregistrer voiture ──────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'marque'          => 'required|string|max:255',
            'modele'          => 'required|string|max:255',
            'annee'           => 'required|integer|min:1990|max:' . date('Y'),
            'prix_journalier' => 'required|numeric|min:1',
            'disponibilite'   => 'required|boolean',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type_assurance'  => 'required|string',
            'numero_police'   => 'required|string|max:255',
            'date_debut'      => 'required|date',
            'date_expiration' => 'required|date|after:today',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('voitures', 'public');
        }

        $voiture = Voiture::create([
            'marque'        => $request->marque,
            'modele'        => $request->modele,
            'annee'         => $request->annee,
            'prix_par_jour' => $request->prix_journalier,
            'disponibilite' => $request->disponibilite,
            'image'         => $imagePath,
            'user_id'       => Auth::id(),
        ]);

        Assurance::create([
            'voiture_id'     => $voiture->id,
            'type_assurance' => $request->type_assurance,
            'numero_police'  => $request->numero_police,
            'date_debut'     => $request->date_debut,
            'date_fin'       => $request->date_expiration,
        ]);

        return redirect()->route('voitures.index')
                         ->with('success', 'Véhicule ajouté avec succès !');
    }

    // ─── Formulaire modification ──────────────────────────────
    public function edit(Voiture $voiture)
    {
        $voiture->load('assurance');
        return view('voitures.edit', compact('voiture'));
    }

    // ─── Mettre à jour ────────────────────────────────────────
    public function update(Request $request, Voiture $voiture)
    {
        $request->validate([
            'marque'          => 'required|string|max:255',
            'modele'          => 'required|string|max:255',
            'annee'           => 'required|integer|min:1990|max:' . date('Y'),
            'prix_journalier' => 'required|numeric|min:1',
            'disponibilite'   => 'required|boolean',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $voiture->image = $request->file('image')->store('voitures', 'public');
        }

        $voiture->update([
            'marque'        => $request->marque,
            'modele'        => $request->modele,
            'annee'         => $request->annee,
            'prix_par_jour' => $request->prix_journalier,
            'disponibilite' => $request->disponibilite,
            'image'         => $voiture->image,
        ]);

        return redirect()->route('voitures.index')
                         ->with('success', 'Véhicule modifié avec succès !');
    }

    // ─── Supprimer ────────────────────────────────────────────
    public function destroy(Voiture $voiture)
    {
        $voiture->assurance()->delete();
        $voiture->delete();

        return redirect()->route('voitures.index')
                         ->with('success', 'Véhicule supprimé avec succès !');
    }

    // ─── Toggle disponibilité ─────────────────────────────────
    public function toggleDisponibilite(Voiture $voiture)
    {
        $voiture->update([
            'disponibilite' => !$voiture->disponibilite
        ]);

        return back()->with('success', 'Disponibilité mise à jour.');
    }
}