@extends('layouts.app')
@section('title', 'Mon Espace Client')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">
            <i class="fas fa-user-circle me-2" style="color:#00b4d8;"></i>
            Bonjour, {{ Auth::user()->prenom }} !
        </h2>
        <small class="text-muted">Espace Client — {{ Auth::user()->email }}</small>
    </div>
    <a href="{{ route('voitures.index') }}" class="btn text-white fw-semibold rounded-3" style="background:#00b4d8;">
        <i class="fas fa-search me-2"></i>Chercher une voiture
    </a>
</div>

{{-- Statistiques --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 text-center py-3">
            <div class="fs-2 fw-bold" style="color:#00b4d8;">{{ $reservations->count() }}</div>
            <div class="text-muted small">Réservations totales</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 text-center py-3">
            <div class="fs-2 fw-bold text-success">{{ $reservations->where('statut','confirmee')->count() }}</div>
            <div class="text-muted small">Confirmées</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 text-center py-3">
            <div class="fs-2 fw-bold" style="color:#1a2e44;">
                {{ number_format($reservations->where('statut','confirmee')->sum('montant_total'), 0) }} MAD
            </div>
            <div class="text-muted small">Total dépensé</div>
        </div>
    </div>
</div>

{{-- Liste des réservations --}}
<h5 class="fw-bold mb-3"><i class="fas fa-calendar-check me-2"></i>Mes Réservations</h5>

@forelse($reservations as $reservation)
<div class="card shadow-sm border-0 rounded-4 mb-3">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                @if($reservation->voiture->image)
                    <img src="{{ Storage::url($reservation->voiture->image) }}"
                         class="rounded-3" style="width:80px;height:60px;object-fit:cover"
                         alt="{{ $reservation->voiture->marque }}">
                @else
                    <div class="fs-2">🚗</div>
                @endif
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold mb-1">
                    {{ $reservation->voiture->marque }} {{ $reservation->voiture->modele }}
                    ({{ $reservation->voiture->annee }})
                </h6>
                <small class="text-muted">
                    <i class="fas fa-calendar me-1"></i>
                    {{ $reservation->date_debut }} → {{ $reservation->date_fin }}
                    ({{ $reservation->nombreJours() }} jour(s))
                </small>
            </div>
            <div class="col-md-2 text-center">
                <span class="badge rounded-pill
                    @if($reservation->statut === 'confirmee') bg-success
                    @elseif($reservation->statut === 'annulee') bg-danger
                    @else bg-warning text-dark @endif">
                    {{ ucfirst(str_replace('_',' ',$reservation->statut)) }}
                </span>
            </div>
            <div class="col-md-2 text-center fw-bold" style="color:#00b4d8;">
                {{ number_format($reservation->montant_total, 0) }} MAD
            </div>
            <div class="col-md-2 text-end d-flex flex-column gap-1">
                @if($reservation->facture)
                    <a href="{{ route('factures.show', $reservation->facture) }}"
                       class="btn btn-sm btn-outline-secondary rounded-pill">
                        <i class="fas fa-file-invoice me-1"></i>Facture
                    </a>
                @endif
                @if($reservation->statut !== 'annulee')
                    <form method="POST" action="{{ route('reservations.destroy', $reservation) }}"
                          onsubmit="return confirm('Annuler cette réservation ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger rounded-pill w-100">
                            <i class="fas fa-times me-1"></i>Annuler
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@empty
    <div class="text-center text-muted py-5">
        <i class="fas fa-calendar-times fa-3x mb-3 d-block opacity-25"></i>
        <p>Vous n'avez pas encore de réservation.</p>
        <a href="{{ route('voitures.index') }}" class="btn text-white" style="background:#00b4d8;">
            <i class="fas fa-car me-2"></i>Voir les voitures disponibles
        </a>
    </div>
@endforelse
@endsection