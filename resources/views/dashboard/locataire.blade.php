@extends('layouts.app')
@section('title', 'Mon Espace Locataire')

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
        --secondary: #5f5e5a;
        --secondary-bg: #f1efe8;
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

    /* ── Header ── */
    .dash-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 2rem;
    }
    .dash-header-left { display: flex; align-items: center; gap: 14px; }
    .user-avatar {
        width: 48px; height: 48px; border-radius: 50%;
        background: var(--brand-light);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 600; color: var(--brand); flex-shrink: 0;
    }
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

    /* ── Stats ── */
    .stats-grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 14px; margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 1.125rem 1.25rem;
        display: flex; align-items: center; gap: 12px;
        box-shadow: var(--shadow-sm); transition: box-shadow .2s;
    }
    .stat-card:hover { box-shadow: var(--shadow-md); }
    .stat-icon {
        width: 44px; height: 44px; border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0;
    }
    .stat-icon.blue   { background: var(--brand-light); color: var(--brand); }
    .stat-icon.green  { background: var(--success-bg);  color: var(--success); }
    .stat-icon.amber  { background: var(--warning-bg);  color: var(--warning); }
    .stat-icon.dark   { background: #eef1f5; color: var(--text-primary); }
    .stat-num  { font-size: 22px; font-weight: 600; color: var(--text-primary); line-height: 1; }
    .stat-num.blue   { color: var(--brand); }
    .stat-num.green  { color: var(--success); }
    .stat-num.amber  { color: var(--warning); }
    .stat-label { font-size: 12px; color: var(--text-secondary); margin-top: 3px; }

    /* ── Section ── */
    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
    .section-title {
        font-size: 16px; font-weight: 600; color: var(--text-primary);
        display: flex; align-items: center; gap: 8px; margin: 0;
    }
    .section-title i { color: var(--brand); }
    .divider { height: 1px; background: var(--border); margin: 2rem 0; }

    /* ── Voiture card ── */
    .voiture-card {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 1.125rem 1.5rem;
        margin-bottom: 10px;
        display: grid; grid-template-columns: 72px 1fr auto auto auto;
        align-items: center; gap: 18px;
        box-shadow: var(--shadow-sm); transition: box-shadow .2s, border-color .2s;
    }
    .voiture-card:hover { box-shadow: var(--shadow-md); border-color: #d0d8e4; }

    .car-thumb {
        width: 72px; height: 54px; border-radius: var(--radius-sm);
        overflow: hidden; background: var(--bg-page);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .car-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .car-thumb-placeholder { font-size: 28px; color: var(--text-muted); }

    .car-name { font-size: 15px; font-weight: 600; color: var(--text-primary); margin-bottom: 3px; }
    .car-meta { font-size: 12px; color: var(--text-secondary); margin-bottom: 3px; }
    .car-assurance {
        font-size: 12px; display: inline-flex; align-items: center; gap: 4px;
    }
    .car-assurance.valid { color: var(--success); }
    .car-assurance.invalid { color: var(--danger); }

    /* badges */
    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 13px; border-radius: 20px;
        font-size: 12px; font-weight: 600; white-space: nowrap;
    }
    .badge-success    { background: var(--success-bg); color: var(--success); }
    .badge-danger     { background: var(--danger-bg);  color: var(--danger); }
    .badge-warning    { background: var(--warning-bg); color: var(--warning); }
    .badge-secondary  { background: var(--secondary-bg); color: var(--secondary); }

    .car-price { font-size: 15px; font-weight: 600; color: var(--brand); white-space: nowrap; }

    /* action buttons */
    .car-actions { display: flex; flex-direction: column; gap: 6px; align-items: flex-end; }
    .btn-action {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 13px; border-radius: 20px;
        font-size: 12px; font-weight: 500;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer; white-space: nowrap; text-decoration: none;
        border: 1px solid var(--border); background: var(--bg-card);
        color: var(--text-primary); transition: background .15s;
    }
    .btn-action:hover { background: var(--bg-page); color: var(--text-primary); }
    .btn-action.toggle-on  { background: var(--success-bg); color: var(--success); border-color: transparent; }
    .btn-action.toggle-on:hover  { background: #d0f0e5; }
    .btn-action.toggle-off { background: var(--warning-bg); color: var(--warning); border-color: transparent; }
    .btn-action.toggle-off:hover { background: #f5dfc0; }
    .btn-action.del        { background: var(--danger-bg);  color: var(--danger);  border-color: transparent; }
    .btn-action.del:hover  { background: #f7c1c1; }

    /* ── Reservation rows ── */
    .res-row {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 1rem 1.5rem;
        margin-bottom: 8px;
        display: grid; grid-template-columns: 1fr 1fr auto auto auto;
        align-items: center; gap: 16px;
        box-shadow: var(--shadow-sm); transition: box-shadow .2s;
    }
    .res-row:hover { box-shadow: var(--shadow-md); }
    .res-row.annulee { opacity: 0.68; }

    .res-car-name { font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 3px; }
    .res-dates { font-size: 12px; color: var(--text-secondary); display: flex; align-items: center; gap: 4px; }

    .user-chip { display: flex; align-items: center; gap: 10px; }
    .user-initials {
        width: 34px; height: 34px; border-radius: 50%;
        background: var(--brand-light); color: var(--brand);
        font-size: 12px; font-weight: 600;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .user-name { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .user-email { font-size: 11px; color: var(--text-secondary); margin-top: 1px; }

    .res-amount { font-size: 15px; font-weight: 600; color: var(--brand); white-space: nowrap; }
    .res-amount.muted { color: var(--text-muted); }

    /* ── Empty ── */
    .empty-state {
        text-align: center; padding: 3rem 2rem;
        background: var(--bg-card); border: 1px dashed var(--border);
        border-radius: var(--radius-lg);
    }
    .empty-state i { font-size: 36px; color: var(--text-muted); margin-bottom: 1rem; display: block; }
    .empty-state p { color: var(--text-secondary); margin-bottom: 1.25rem; }

    /* ── Alert flash ── */
    .flash-alert {
        background: var(--success-bg); color: var(--success);
        border: 1px solid #9fe1cb; border-radius: var(--radius-md);
        padding: 12px 18px; margin-bottom: 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        font-size: 14px;
    }
    .flash-alert button {
        background: none; border: none; color: var(--success);
        cursor: pointer; font-size: 16px; line-height: 1;
    }

    @media (max-width: 992px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .voiture-card { grid-template-columns: 56px 1fr; grid-template-rows: auto auto auto; }
        .car-price, .car-actions { grid-column: 2; }
        .res-row { grid-template-columns: 1fr; }
        .dash-header { flex-wrap: wrap; gap: 12px; }
    }
</style>
@endpush

@section('content')

{{-- Flash message --}}
@if(session('success'))
<div class="flash-alert" id="flash-msg">
    <span><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</span>
    <button onclick="document.getElementById('flash-msg').remove()" aria-label="Fermer">×</button>
</div>
@endif

{{-- Header --}}
<div class="dash-header">
    <div class="dash-header-left">
        <div class="user-avatar">
            {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}
        </div>
        <div>
            <h2 class="dash-title">Bonjour, {{ Auth::user()->prenom }} !</h2>
            <p class="dash-subtitle">
                <i class="fas fa-home me-1"></i>
                Espace Locataire — {{ Auth::user()->email }}
            </p>
        </div>
    </div>
    <a href="{{ route('voitures.create') }}" class="btn-brand">
        <i class="fas fa-plus"></i> Ajouter une voiture
    </a>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-car"></i></div>
        <div>
            <div class="stat-num blue">{{ $voitures->count() }}</div>
            <div class="stat-label">Mes voitures</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="stat-num green">{{ $voitures->where('disponibilite', true)->count() }}</div>
            <div class="stat-label">Disponibles</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber"><i class="fas fa-calendar-check"></i></div>
        <div>
            <div class="stat-num amber">{{ $reservations->count() }}</div>
            <div class="stat-label">Réservations reçues</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon dark"><i class="fas fa-chart-line"></i></div>
        <div>
            <div class="stat-num" style="font-size:18px;">
                {{ number_format($reservations->where('statut','confirmee')->sum('montant_total'), 0) }} MAD
            </div>
            <div class="stat-label">Revenus totaux</div>
        </div>
    </div>
</div>

{{-- ── MES VOITURES ── --}}
<div class="section-header">
    <h5 class="section-title">
        <i class="fas fa-car"></i> Mes voitures
    </h5>
    <a href="{{ route('voitures.create') }}" class="btn-brand" style="padding:8px 16px;font-size:13px;">
        <i class="fas fa-plus"></i> Ajouter
    </a>
</div>

@forelse($voitures as $voiture)
<div class="voiture-card">

    {{-- Image --}}
    <div class="car-thumb">
        @if($voiture->image)
            <img src="{{ Storage::url($voiture->image) }}" alt="{{ $voiture->marque }}">
        @else
            <span class="car-thumb-placeholder">🚗</span>
        @endif
    </div>

    {{-- Infos --}}
    <div>
        <div class="car-name">{{ $voiture->marque }} {{ $voiture->modele }} ({{ $voiture->annee }})</div>
        <div class="car-meta">{{ $voiture->carburant }} · {{ $voiture->transmission }}</div>
        @if($voiture->assurance)
            @if($voiture->assuranceValide())
                <span class="car-assurance valid">
                    <i class="fas fa-shield-alt"></i>
                    {{ $voiture->assurance->type_assurance }}
                </span>
            @else
                <span class="car-assurance invalid">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $voiture->assurance->type_assurance }}
                    <span class="badge badge-danger ms-1" style="padding:2px 8px;font-size:10px;">Expirée</span>
                </span>
            @endif
        @else
            <span class="car-assurance invalid">
                <i class="fas fa-shield-alt"></i> Sans assurance
            </span>
        @endif
    </div>

    {{-- Disponibilité --}}
    <span class="badge {{ $voiture->disponibilite ? 'badge-success' : 'badge-secondary' }}">
        @if($voiture->disponibilite)
            <i class="fas fa-check" style="font-size:10px;"></i> Disponible
        @else
            <i class="fas fa-pause" style="font-size:10px;"></i> Indisponible
        @endif
    </span>

    {{-- Prix --}}
    <div class="car-price">{{ number_format($voiture->prix_par_jour, 0) }} MAD/jour</div>

    {{-- Actions --}}
    <div class="car-actions">
        <a href="{{ route('voitures.edit', $voiture) }}" class="btn-action">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <form method="POST" action="{{ route('voitures.toggle', $voiture) }}">
            @csrf
            <button type="submit"
                class="btn-action {{ $voiture->disponibilite ? 'toggle-off' : 'toggle-on' }}">
                @if($voiture->disponibilite)
                    <i class="fas fa-pause-circle"></i> Désactiver
                @else
                    <i class="fas fa-play-circle"></i> Activer
                @endif
            </button>
        </form>
        <form method="POST" action="{{ route('voitures.destroy', $voiture) }}"
              onsubmit="return confirm('Supprimer cette voiture ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-action del">
                <i class="fas fa-trash"></i> Supprimer
            </button>
        </form>
    </div>
</div>
@empty
<div class="empty-state">
    <i class="fas fa-car-side"></i>
    <p>Vous n'avez pas encore ajouté de voiture.</p>
    <a href="{{ route('voitures.create') }}" class="btn-brand">
        <i class="fas fa-plus me-1"></i> Ajouter ma première voiture
    </a>
</div>
@endforelse

<div class="divider"></div>

{{-- ── RÉSERVATIONS REÇUES ── --}}
<div class="section-header">
    <h5 class="section-title">
        <i class="fas fa-list-alt"></i> Réservations reçues
    </h5>
    @if($reservations->count() > 0)
        <span class="badge badge-warning">{{ $reservations->count() }} au total</span>
    @endif
</div>

@forelse($reservations as $reservation)
<div class="res-row {{ $reservation->statut === 'annulee' ? 'annulee' : '' }}">

    {{-- Voiture + dates --}}
    <div>
        <div class="res-car-name">
            {{ $reservation->voiture->marque }} {{ $reservation->voiture->modele }}
        </div>
        <div class="res-dates">
            <i class="fas fa-calendar-day" style="font-size:11px;"></i>
            {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}
            <i class="fas fa-arrow-right" style="font-size:9px;"></i>
            {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
            <span style="color:var(--text-muted)">· {{ $reservation->nombreJours() }}j</span>
        </div>
    </div>

    {{-- Client --}}
    <div class="user-chip">
        <div class="user-initials">
            {{ strtoupper(substr($reservation->user->prenom, 0, 1)) }}{{ strtoupper(substr($reservation->user->nom, 0, 1)) }}
        </div>
        <div>
            <div class="user-name">{{ $reservation->user->prenom }} {{ $reservation->user->nom }}</div>
            <div class="user-email">{{ $reservation->user->email }}</div>
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

    {{-- Facture --}}
    <div>
        @if($reservation->facture)
            <a href="{{ route('factures.show', $reservation->facture) }}" class="btn-action">
                <i class="fas fa-file-invoice"></i> Facture
            </a>
        @else
            <span style="font-size:12px;color:var(--text-muted);">—</span>
        @endif
    </div>
</div>
@empty
<div class="empty-state">
    <i class="fas fa-inbox"></i>
    <p>Aucune réservation reçue pour l'instant.</p>
</div>
@endforelse

@endsection