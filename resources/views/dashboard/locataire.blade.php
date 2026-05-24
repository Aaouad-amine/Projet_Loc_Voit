@extends('layouts.app')
@section('title', 'Mon Espace Locataire')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">
            <i class="fas fa-home me-2" style="color:#00b4d8;"></i>
            Bonjour, {{ Auth::user()->prenom }} !
        </h2>
        <small class="text-muted">Espace Locataire — {{ Auth::user()->email }}</small>
    </div>
    <a href="{{ route('voitures.create') }}" class="btn text-white fw-semibold rounded-3" style="background:#00b4d8;">
        <i class="fas fa-plus me-2"></i>Ajouter une voiture
    </a>
</div>

{{-- Statistiques --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 text-center py-3">
            <div class="fs-2 fw-bold" style="color:#00b4d8;">{{ $voitures->count() }}</div>
            <div class="text-muted small">Mes voitures</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 text-center py-3">
            <div class="fs-2 fw-bold text-success">{{ $voitures->where('disponibilite', true)->count() }}</div>
            <div class="text-muted small">Disponibles</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 text-center py-3">
            <div class="fs-2 fw-bold text-warning">{{ $reservations->count() }}</div>
            <div class="text-muted small">Réservations reçues</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 text-center py-3">
            <div class="fs-2 fw-bold" style="color:#1a2e44;">
                {{ number_format($reservations->where('statut','confirmee')->sum('montant_total'), 0) }} MAD
            </div>
            <div class="text-muted small">Revenus totaux</div>
        </div>
    </div>
</div>

{{-- Mes voitures --}}
<h5 class="fw-bold mb-3"><i class="fas fa-car me-2"></i>Mes voitures</h5>

@forelse($voitures as $voiture)
<div class="card shadow-sm border-0 rounded-4 mb-3">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                @if($voiture->image)
                    <img src="{{ Storage::url($voiture->image) }}"
                         class="rounded-3" style="width:80px;height:60px;object-fit:cover"
                         alt="{{ $voiture->marque }}">
                @else
                    <div class="fs-2">🚗</div>
                @endif
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold mb-1">{{ $voiture->marque }} {{ $voiture->modele }} ({{ $voiture->annee }})</h6>
                <small class="text-muted">
                    {{ $voiture->carburant }} · {{ $voiture->transmission }}
                </small><br>
                <small>
                    🛡️ {{ $voiture->assurance->type_assurance ?? 'Sans assurance' }}
                    @if($voiture->assurance && !$voiture->assuranceValide())
                        <span class="badge bg-danger ms-1">Expirée</span>
                    @endif
                </small>
            </div>
            <div class="col-md-2 text-center">
                <span class="badge rounded-pill {{ $voiture->disponibilite ? 'bg-success' : 'bg-secondary' }}">
                    {{ $voiture->disponibilite ? 'Disponible' : 'Indisponible' }}
                </span>
            </div>
            <div class="col-md-2 text-center fw-bold" style="color:#00b4d8;">
                {{ number_format($voiture->prix_par_jour, 0) }} MAD/jour
            </div>
            <div class="col-md-2 text-end d-flex flex-column gap-1">
                <a href="{{ route('voitures.edit', $voiture) }}"
                   class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="fas fa-edit me-1"></i>Modifier
                </a>
                <form method="POST" action="{{ route('voitures.toggle', $voiture) }}">
                    @csrf
                    <button class="btn btn-sm rounded-pill w-100 {{ $voiture->disponibilite ? 'btn-warning' : 'btn-success' }}">
                        {{ $voiture->disponibilite ? 'Désactiver' : 'Activer' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('voitures.destroy', $voiture) }}"
                      onsubmit="return confirm('Supprimer cette voiture ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger rounded-pill w-100">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@empty
    <div class="text-center text-muted py-4">
        <p>Vous n'avez pas encore ajouté de voiture.</p>
        <a href="{{ route('voitures.create') }}" class="btn text-white" style="background:#00b4d8;">
            <i class="fas fa-plus me-2"></i>Ajouter ma première voiture
        </a>
    </div>
@endforelse

{{-- Réservations reçues --}}
<h5 class="fw-bold mb-3 mt-5"><i class="fas fa-list-alt me-2"></i>Réservations reçues</h5>

@forelse($reservations as $reservation)
<div class="card shadow-sm border-0 rounded-4 mb-3">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-3">
                <strong>{{ $reservation->voiture->marque }} {{ $reservation->voiture->modele }}</strong><br>
                <small class="text-muted">
                    <i class="fas fa-calendar me-1"></i>
                    {{ $reservation->date_debut }} → {{ $reservation->date_fin }}
                </small>
            </div>
            <div class="col-md-3">
                <i class="fas fa-user me-1 text-muted"></i>
                {{ $reservation->user->prenom }} {{ $reservation->user->nom }}<br>
                <small class="text-muted">{{ $reservation->user->email }}</small>
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
            <div class="col-md-2 text-end">
                @if($reservation->facture)
                    <a href="{{ route('factures.show', $reservation->facture) }}"
                       class="btn btn-sm btn-outline-secondary rounded-pill">
                        <i class="fas fa-file-invoice me-1"></i>Facture
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@empty
    <div class="text-center text-muted py-3">
        <p>Aucune réservation reçue pour l'instant.</p>
    </div>
@endforelse
@endsection