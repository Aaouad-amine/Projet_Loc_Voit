@extends('layouts.app')
@section('title', 'Mon Espace Client')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --brand: #00b4d8;
        --brand-dark: #0097b8;
        --brand-light: #e1f8fd;
        --success: #0f6e56;
        --success-bg: #e5f8f0;
        --danger: #a32d2d;
        --danger-bg: #fcebeb;
        --warning: #854f0b;
        --warning-bg: #faeeda;
        --text-primary: #1a2e44;
        --text-secondary: #6b7a8d;
        --text-muted: #9aa5b4;
        --bg-page: #f5f7fa;
        --bg-card: #ffffff;
        --border: #e8ecf0;
        --radius-sm: 10px;
        --radius-md: 14px;
        --radius-lg: 18px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 12px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.04);
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-page); }

    /* ── Top header ── */
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .dash-header-left { display: flex; align-items: center; gap: 14px; }
    .user-avatar {
        width: 48px; height: 48px; border-radius: 50%;
        background: var(--brand-light);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; font-weight: 600; color: var(--brand);
        flex-shrink: 0;
    }
    .user-avatar-text { font-size: 16px; font-weight: 600; color: var(--brand); }
    .dash-title { font-size: 22px; font-weight: 600; color: var(--text-primary); margin: 0; }
    .dash-subtitle { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }

    .btn-brand {
        background: var(--brand); color: #fff;
        border: none; border-radius: var(--radius-sm);
        padding: 10px 20px; font-size: 14px; font-weight: 500;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
        text-decoration: none; transition: background .2s, transform .1s;
    }
    .btn-brand:hover { background: var(--brand-dark); color: #fff; transform: translateY(-1px); }
    .btn-brand:active { transform: translateY(0); }

    /* ── Stat cards ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.25rem 1.5rem;
        display: flex; align-items: center; gap: 14px;
        box-shadow: var(--shadow-sm);
        transition: box-shadow .2s;
    }
    .stat-card:hover { box-shadow: var(--shadow-md); }
    .stat-icon {
        width: 46px; height: 46px; border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; flex-shrink: 0;
    }
    .stat-icon.blue  { background: var(--brand-light); color: var(--brand); }
    .stat-icon.green { background: var(--success-bg); color: var(--success); }
    .stat-icon.dark  { background: #eef1f5; color: var(--text-primary); }
    .stat-num { font-size: 24px; font-weight: 600; color: var(--text-primary); line-height: 1; }
    .stat-num.blue  { color: var(--brand); }
    .stat-num.green { color: var(--success); }
    .stat-label { font-size: 12px; color: var(--text-secondary); margin-top: 3px; }

    /* ── Section ── */
    .section-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1rem;
    }
    .section-title {
        font-size: 16px; font-weight: 600; color: var(--text-primary);
        display: flex; align-items: center; gap: 8px; margin: 0;
    }
    .section-title i { color: var(--brand); font-size: 18px; }

    /* ── Filter tabs ── */
    .filter-tabs {
        display: flex; gap: 6px; margin-bottom: 1.25rem;
        border-bottom: 1px solid var(--border); padding-bottom: 0;
    }
    .filter-tab {
        padding: 8px 16px; font-size: 13px; font-weight: 500;
        color: var(--text-secondary); cursor: pointer;
        border: none; background: none;
        border-bottom: 2px solid transparent;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: color .2s, border-color .2s;
        margin-bottom: -1px;
    }
    .filter-tab:hover { color: var(--brand); }
    .filter-tab.active { color: var(--brand); border-bottom-color: var(--brand); }

    /* ── Reservation cards ── */
    .res-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.125rem 1.5rem;
        margin-bottom: 10px;
        display: grid;
        grid-template-columns: 72px 1fr auto auto auto;
        align-items: center;
        gap: 18px;
        box-shadow: var(--shadow-sm);
        transition: box-shadow .2s, border-color .2s;
    }
    .res-card:hover { box-shadow: var(--shadow-md); border-color: #d0d8e4; }
    .res-card.annulee { opacity: 0.68; }

    .car-thumb {
        width: 72px; height: 54px; border-radius: var(--radius-sm);
        object-fit: cover; background: var(--bg-page);
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; flex-shrink: 0;
    }
    .car-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .car-thumb-placeholder { font-size: 28px; color: var(--text-muted); }

    .res-car-name { font-size: 15px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px; }
    .res-dates {
        font-size: 12px; color: var(--text-secondary);
        display: flex; align-items: center; gap: 5px;
    }
    .res-dates i { font-size: 13px; }

    /* badges */
    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 13px; border-radius: 20px;
        font-size: 12px; font-weight: 600; white-space: nowrap;
    }
    .badge-success { background: var(--success-bg); color: var(--success); }
    .badge-danger  { background: var(--danger-bg);  color: var(--danger); }
    .badge-warning { background: var(--warning-bg); color: var(--warning); }

    .res-amount { font-size: 16px; font-weight: 600; color: var(--brand); white-space: nowrap; }
    .res-amount.muted { color: var(--text-muted); }

    .res-actions { display: flex; flex-direction: column; gap: 6px; align-items: flex-end; }

    .btn-sm {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 13px; border-radius: 20px;
        font-size: 12px; font-weight: 500;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer; border: 1px solid var(--border);
        background: var(--bg-card); color: var(--text-primary);
        white-space: nowrap; text-decoration: none;
        transition: background .15s, border-color .15s;
    }
    .btn-sm:hover { background: var(--bg-page); color: var(--text-primary); border-color: #c0cad4; }
    .btn-sm-danger {
        border-color: transparent; background: var(--danger-bg);
        color: var(--danger);
    }
    .btn-sm-danger:hover { background: #f7c1c1; }

    /* ── Empty state ── */
    .empty-state {
        text-align: center; padding: 3.5rem 2rem;
        background: var(--bg-card); border: 1px dashed var(--border);
        border-radius: var(--radius-lg);
    }
    .empty-state i { font-size: 40px; color: var(--text-muted); margin-bottom: 1rem; display: block; }
    .empty-state p { color: var(--text-secondary); margin-bottom: 1.25rem; }

    /* ── Divider ── */
    .divider { height: 1px; background: var(--border); margin: 2rem 0; }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .res-card { grid-template-columns: 56px 1fr; grid-template-rows: auto auto auto; }
        .res-amount, .res-actions { grid-column: 2; }
        .dash-header { flex-wrap: wrap; gap: 12px; }
    }
</style>
@endpush

@section('content')

<div class="dash-header">
    <div class="dash-header-left">
        <div class="user-avatar">
            <span class="user-avatar-text">{{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}</span>
        </div>
        <div>
            <h2 class="dash-title">Bonjour, {{ Auth::user()->prenom }} !</h2>
            <p class="dash-subtitle">
                <i class="fas fa-id-badge me-1"></i>
                Espace Client — {{ Auth::user()->email }}
            </p>
        </div>
    </div>
    <a href="{{ route('voitures.index') }}" class="btn-brand">
        <i class="fas fa-search"></i> Chercher une voiture
    </a>
</div>

{{-- Statistiques --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div>
            <div class="stat-num blue">{{ $reservations->count() }}</div>
            <div class="stat-label">Réservations totales</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div class="stat-num green">{{ $reservations->where('statut','confirmee')->count() }}</div>
            <div class="stat-label">Confirmées</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon dark">
            <i class="fas fa-wallet"></i>
        </div>
        <div>
            <div class="stat-num">{{ number_format($reservations->where('statut','confirmee')->sum('montant_total'), 0) }} MAD</div>
            <div class="stat-label">Total dépensé</div>
        </div>
    </div>
</div>

{{-- Section réservations --}}
<div class="section-header">
    <h5 class="section-title">
        <i class="fas fa-calendar-check"></i> Mes réservations
    </h5>
</div>

{{-- Onglets de filtre --}}
@php
    $total     = $reservations->count();
    $confirmee = $reservations->where('statut','confirmee')->count();
    $annulee   = $reservations->where('statut','annulee')->count();
    $enAttente = $total - $confirmee - $annulee;
@endphp
<div class="filter-tabs">
    <button class="filter-tab active" onclick="filterRes('all', this)">Toutes ({{ $total }})</button>
    <button class="filter-tab" onclick="filterRes('confirmee', this)">Confirmées ({{ $confirmee }})</button>
    @if($enAttente > 0)
    <button class="filter-tab" onclick="filterRes('en_attente', this)">En attente ({{ $enAttente }})</button>
    @endif
    <button class="filter-tab" onclick="filterRes('annulee', this)">Annulées ({{ $annulee }})</button>
</div>

{{-- Liste des réservations --}}
@forelse($reservations as $reservation)
<div class="res-card {{ $reservation->statut === 'annulee' ? 'annulee' : '' }}"
     data-statut="{{ $reservation->statut }}">

    {{-- Image voiture --}}
    <div class="car-thumb">
        @if($reservation->voiture->image)
            <img src="{{ Storage::url($reservation->voiture->image) }}"
                 alt="{{ $reservation->voiture->marque }}">
        @else
            <span class="car-thumb-placeholder">🚗</span>
        @endif
    </div>

    {{-- Infos voiture --}}
    <div>
        <div class="res-car-name">
            {{ $reservation->voiture->marque }} {{ $reservation->voiture->modele }}
            <span style="font-weight:400;font-size:13px;color:var(--text-secondary);">({{ $reservation->voiture->annee }})</span>
        </div>
        <div class="res-dates">
            <i class="fas fa-calendar-day"></i>
            {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}
            <i class="fas fa-arrow-right" style="font-size:10px;"></i>
            {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
            <span style="color:var(--text-muted);">· {{ $reservation->nombreJours() }} jour(s)</span>
        </div>
    </div>

    {{-- Statut --}}
    <span class="badge
        @if($reservation->statut === 'confirmee') badge-success
        @elseif($reservation->statut === 'annulee') badge-danger
        @else badge-warning
        @endif">
        @if($reservation->statut === 'confirmee')
            <i class="fas fa-check" style="font-size:10px;"></i>
        @elseif($reservation->statut === 'annulee')
            <i class="fas fa-ban" style="font-size:10px;"></i>
        @else
            <i class="fas fa-clock" style="font-size:10px;"></i>
        @endif
        {{ ucfirst(str_replace('_',' ',$reservation->statut)) }}
    </span>

    {{-- Montant --}}
    <div class="res-amount {{ $reservation->montant_total == 0 ? 'muted' : '' }}">
        {{ number_format($reservation->montant_total, 0) }} MAD
    </div>

    {{-- Actions --}}
    <div class="res-actions">
        @if($reservation->facture)
            <a href="{{ route('factures.show', $reservation->facture) }}" class="btn-sm">
                <i class="fas fa-file-invoice"></i> Facture
            </a>
        @endif
        @if($reservation->statut !== 'annulee')
            <form method="POST" action="{{ route('reservations.destroy', $reservation) }}"
                  onsubmit="return confirm('Annuler cette réservation ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-sm-danger">
                    <i class="fas fa-times"></i> Annuler
                </button>
            </form>
        @endif
    </div>
</div>
@empty
<div class="empty-state">
    <i class="fas fa-calendar-times"></i>
    <p>Vous n'avez pas encore de réservation.</p>
    <a href="{{ route('voitures.index') }}" class="btn-brand">
        <i class="fas fa-car me-1"></i> Voir les voitures disponibles
    </a>
</div>
@endforelse

@push('scripts')
<script>
function filterRes(statut, btn) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.res-card').forEach(card => {
        if (statut === 'all') {
            card.style.display = '';
        } else if (statut === 'en_attente') {
            card.style.display = (card.dataset.statut !== 'confirmee' && card.dataset.statut !== 'annulee') ? '' : 'none';
        } else {
            card.style.display = card.dataset.statut === statut ? '' : 'none';
        }
    });
}
</script>
@endpush

@endsection