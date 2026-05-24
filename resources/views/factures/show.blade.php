@extends('layouts.app')
@section('title', 'Facture #' . str_pad($facture->id, 4, '0', STR_PAD_LEFT))
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0 rounded-4">
            {{-- En-tête facture --}}
            <div class="card-header py-4 rounded-top-4" style="background:#1a2e44;">
                <div class="d-flex justify-content-between align-items-center text-white">
                    <div>
                        <h4 class="mb-0 fw-bold">🚗 AutoLouer</h4>
                        <small class="opacity-75">Rabat, Maroc</small>
                    </div>
                    <div class="text-end">
                        <h5 class="mb-0 fw-bold" style="color:#00b4d8;">
                            FACTURE #{{ str_pad($facture->id, 4, '0', STR_PAD_LEFT) }}
                        </h5>
                        <small class="opacity-75">Émise le {{ $facture->date_emission }}</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-muted text-uppercase mb-2" style="letter-spacing:1px;">Client</h6>
                        <strong>{{ $facture->reservation->user->prenom }} {{ $facture->reservation->user->nom }}</strong><br>
                        <span class="text-muted">{{ $facture->reservation->user->email }}</span><br>
                        @if($facture->reservation->user->telephone)
                            <span class="text-muted">{{ $facture->reservation->user->telephone }}</span>
                        @endif
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h6 class="fw-bold text-muted text-uppercase mb-2" style="letter-spacing:1px;">Statut</h6>
                        @php $statut = $facture->reservation->statut; @endphp
                        <span class="badge rounded-pill fs-6
                            {{ $statut === 'confirmee' ? 'bg-success' : ($statut === 'annulee' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ ucfirst(str_replace('_', ' ', $statut)) }}
                        </span>
                    </div>
                </div>

                <h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing:1px;">Détail de la location</h6>
                <div class="table-responsive">
                    <table class="table table-bordered rounded-3 overflow-hidden">
                        <thead style="background:#1a2e44;color:#fff;">
                            <tr>
                                <th>Voiture</th>
                                <th>Période</th>
                                <th class="text-center">Jours</th>
                                <th class="text-center">Prix/jour</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>{{ $facture->reservation->voiture->marque }} {{ $facture->reservation->voiture->modele }}</strong><br>
                                    <small class="text-muted">{{ $facture->reservation->voiture->annee }} · {{ $facture->reservation->voiture->carburant }}</small>
                                </td>
                                <td>
                                    {{ $facture->reservation->date_debut }}<br>
                                    <small class="text-muted">→ {{ $facture->reservation->date_fin }}</small>
                                </td>
                                <td class="text-center fw-bold">{{ $facture->reservation->nombreJours() }}</td>
                                <td class="text-center">{{ number_format($facture->reservation->voiture->prix_par_jour, 0) }} MAD</td>
                                <td class="text-end fw-bold" style="color:#00b4d8;">
                                    {{ number_format($facture->montant_total, 0) }} MAD
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="background:#f8f9fa;">
                                <td colspan="4" class="text-end fw-bold fs-5">TOTAL</td>
                                <td class="text-end fw-bold fs-5" style="color:#00b4d8;">
                                    {{ number_format($facture->montant_total, 0) }} MAD
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-3">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                    <a href="{{ route('factures.download', $facture) }}"
                       class="btn text-white fw-semibold rounded-3" style="background:#1a2e44;">
                        <i class="fas fa-file-pdf me-2"></i>Télécharger PDF
                    </a>
                </div>
            </div>

            <div class="card-footer text-center text-muted small py-3 rounded-bottom-4">
                Merci de votre confiance. — AutoLouer SARL — Rabat, Maroc
            </div>
        </div>
    </div>
</div>
@endsection