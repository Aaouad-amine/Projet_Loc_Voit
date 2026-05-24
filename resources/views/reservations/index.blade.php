@extends('layouts.app')
@section('title', 'Mes Réservations')
@section('content')

<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-calendar-check me-2" style="color:#00b4d8;"></i>Mes Réservations
    </h2>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    @forelse($reservations as $reservation)
    <div class="card shadow-sm border-0 rounded-4 mb-3">
        <div class="card-body">
            <div class="row align-items-center">

                {{-- Image voiture --}}
                <div class="col-md-2 text-center">
                    @if($reservation->voiture && $reservation->voiture->image)
                        <img src="{{ Storage::url($reservation->voiture->image) }}"
                             class="rounded-3" style="width:80px;height:60px;object-fit:cover;"
                             alt="{{ $reservation->voiture->marque }}">
                    @else
                        <div class="fs-1">🚗</div>
                    @endif
                </div>

                {{-- Infos voiture --}}
                <div class="col-md-4">
                    <h6 class="fw-bold mb-1">
                        {{ $reservation->voiture->marque ?? '—' }}
                        {{ $reservation->voiture->modele ?? '' }}
                        ({{ $reservation->voiture->annee ?? '' }})
                    </h6>
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ $reservation->date_debut }} → {{ $reservation->date_fin }}
                        ({{ $reservation->nombreJours() }} jour(s))
                    </small>
                </div>

                {{-- Statut --}}
                <div class="col-md-2 text-center">
                    <span class="badge rounded-pill fs-6
                        @if($reservation->statut === 'confirmee') bg-success
                        @elseif($reservation->statut === 'annulee') bg-danger
                        @else bg-warning text-dark @endif">
                        {{ ucfirst(str_replace('_', ' ', $reservation->statut)) }}
                    </span>
                </div>

                {{-- Montant --}}
                <div class="col-md-2 text-center">
                    <strong style="color:#00b4d8;">
                        {{ number_format($reservation->montant_total, 0) }} MAD
                    </strong>
                </div>

                {{-- Actions --}}
                <div class="col-md-2 text-end d-flex flex-column gap-2">
                    @if($reservation->facture)
                        <a href="{{ route('factures.show', $reservation->facture) }}"
                           class="btn btn-sm btn-outline-secondary rounded-pill">
                            <i class="fas fa-file-invoice me-1"></i>Facture
                        </a>
                    @endif

                    @if($reservation->statut !== 'annulee')
                        <form method="POST"
                              action="{{ route('reservations.destroy', $reservation) }}"
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
        <p>Vous n'avez aucune réservation.</p>
        <a href="{{ route('voitures.index') }}"
           class="btn text-white" style="background:#00b4d8;">
            Parcourir les voitures
        </a>
    </div>
    @endforelse
</div>

@endsection