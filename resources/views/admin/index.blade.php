<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoLux — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
        :root{
            /* ── THÈME CLAIR ── */
            --bg:#F4F5F7;
            --bg2:#FFFFFF;
            --bg3:#FFFFFF;
            --gold:#9A6F00;
            --gl:#B8860B;
            --gd:rgba(184,134,11,.08);
            --gb:rgba(184,134,11,.18);
            --cream:#1C1A16;
            --c2:rgba(28,26,22,.65);
            --c3:rgba(28,26,22,.38);
            --red:#DC2626;
            --green:#16a34a;
            --border:#E5E7EB;
            --sidebar-bg:#FFFFFF;
            --topbar-bg:rgba(255,255,255,.96);
        }
        body{background:var(--bg);color:var(--cream);font-family:'Inter',sans-serif;font-weight:300;min-height:100vh;display:flex;}

        /* ── SIDEBAR ── */
        .sidebar{width:220px;flex-shrink:0;background:var(--sidebar-bg);border-right:1px solid var(--border);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;box-shadow:2px 0 8px rgba(0,0,0,.04);}
        .s-logo{padding:1.6rem 1.4rem;border-bottom:1px solid var(--border);}
        .s-logo a{font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--cream);text-decoration:none;}
        .s-logo a span{color:var(--gold);}
        .s-badge{font-size:.52rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold);background:var(--gd);border:1px solid var(--gb);padding:.18rem .55rem;border-radius:100px;display:inline-block;margin-top:.4rem;}
        .s-nav{flex:1;padding:1rem 0;}
        .s-sec{font-size:.52rem;letter-spacing:.18em;text-transform:uppercase;color:var(--c3);padding:.25rem 1.3rem;margin:.8rem 0 .2rem;}
        .s-link{display:flex;align-items:center;gap:.6rem;padding:.6rem 1.3rem;color:var(--c3);text-decoration:none;font-size:.78rem;transition:all .15s;position:relative;}
        .s-link svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;}
        .s-link:hover,.s-link.active{color:var(--gl);background:rgba(184,134,11,.06);}
        .s-link.active::before{content:'';position:absolute;left:0;top:18%;bottom:18%;width:2px;background:var(--gold);border-radius:2px;}
        .s-bottom{padding:1rem 1.3rem;border-top:1px solid var(--border);}
        .s-user{display:flex;align-items:center;gap:.6rem;margin-bottom:.7rem;}
        .s-ava{width:30px;height:30px;border-radius:50%;background:var(--gd);border:1px solid var(--gb);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:var(--gl);flex-shrink:0;}
        .s-uname{font-size:.75rem;font-weight:500;color:var(--cream);}
        .s-uemail{font-size:.58rem;color:var(--c3);}
        .s-logout{display:flex;align-items:center;gap:.5rem;padding:.48rem .85rem;border:1px solid rgba(220,38,38,.25);border-radius:3px;color:rgba(220,38,38,.65);font-size:.68rem;background:none;cursor:pointer;width:100%;font-family:'Inter',sans-serif;transition:all .15s;}
        .s-logout svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;}
        .s-logout:hover{background:rgba(220,38,38,.06);color:var(--red);border-color:rgba(220,38,38,.4);}

        /* ── MAIN ── */
        .main{flex:1;overflow-y:auto;display:flex;flex-direction:column;}
        .topbar{display:flex;align-items:center;justify-content:space-between;padding:1.2rem 2rem;border-bottom:1px solid var(--border);background:var(--topbar-bg);backdrop-filter:blur(10px);position:sticky;top:0;z-index:10;box-shadow:0 1px 4px rgba(0,0,0,.06);}
        .tb-title{font-family:'Playfair Display',serif;font-size:1.25rem;color:var(--cream);}
        .tb-sub{font-size:.65rem;color:var(--c3);margin-top:.1rem;}
        .tb-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.42rem .9rem;border:1px solid var(--gb);background:var(--gd);color:var(--gl);font-size:.67rem;letter-spacing:.08em;text-transform:uppercase;border-radius:3px;text-decoration:none;transition:all .15s;font-weight:500;}
        .tb-btn svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
        .tb-btn:hover{background:rgba(184,134,11,.14);border-color:var(--gold);}

        /* ── CONTENT ── */
        .content{padding:1.8rem 2rem;flex:1;}

        /* ── KPI ── */
        .kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:.9rem;margin-bottom:1.8rem;}
        .kpi{background:var(--bg3);border:1px solid var(--border);border-radius:8px;padding:1.3rem;position:relative;overflow:hidden;transition:transform .2s, box-shadow .2s;}
        .kpi:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.07);}
        .kpi::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;}
        .kpi.k-gold::before{background:linear-gradient(90deg,var(--gold),#e8b923);}
        .kpi.k-green::before{background:linear-gradient(90deg,#16a34a,#4ade80);}
        .kpi.k-blue::before{background:linear-gradient(90deg,#2563eb,#60a5fa);}
        .kpi.k-red::before{background:linear-gradient(90deg,#dc2626,#f87171);}
        .kpi-ico{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:.8rem;}
        .kpi-ico svg{width:17px;height:17px;stroke:currentColor;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;}
        .k-gold .kpi-ico{background:rgba(184,134,11,.1);color:var(--gold);}
        .k-green .kpi-ico{background:rgba(22,163,74,.1);color:#16a34a;}
        .k-blue .kpi-ico{background:rgba(37,99,235,.1);color:#2563eb;}
        .k-red .kpi-ico{background:rgba(220,38,38,.08);color:#dc2626;}
        .kpi-val{font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:700;color:var(--cream);line-height:1;margin-bottom:.22rem;}
        .kpi-lbl{font-size:.58rem;letter-spacing:.15em;text-transform:uppercase;color:var(--c3);}

        /* ── TABS ── */
        .tabs{display:flex;gap:.3rem;margin-bottom:1.2rem;border-bottom:1px solid var(--border);padding-bottom:0;}
        .tab{padding:.55rem 1.1rem;font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--c3);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-1px;transition:all .15s;background:none;border-top:none;border-left:none;border-right:none;font-family:'Inter',sans-serif;}
        .tab:hover{color:var(--cream);}
        .tab.active{color:var(--gl);border-bottom-color:var(--gold);}

        /* ── PANEL ── */
        .panel{background:var(--bg3);border:1px solid var(--border);border-radius:8px;overflow:hidden;display:none;box-shadow:0 1px 4px rgba(0,0,0,.04);}
        .panel.active{display:block;}
        .ph{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:#FAFAFA;}
        .ph-title{font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:var(--gl);}
        .ph-count{font-size:.65rem;color:var(--c3);}

        /* ── TABLE ── */
        .tbl{width:100%;border-collapse:collapse;}
        .tbl th{font-size:.56rem;letter-spacing:.14em;text-transform:uppercase;color:var(--c3);padding:.65rem 1.2rem;text-align:left;font-weight:500;border-bottom:1px solid var(--border);background:#FAFAFA;}
        .tbl td{padding:.78rem 1.2rem;border-bottom:1px solid #F3F4F6;font-size:.77rem;color:var(--c2);vertical-align:middle;}
        .tbl tr:last-child td{border-bottom:none;}
        .tbl tr:hover td{background:#F9FAFB;}
        .ava{width:27px;height:27px;border-radius:50%;background:var(--gd);border:1px solid var(--gb);display:inline-flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:600;color:var(--gl);margin-right:.45rem;vertical-align:middle;flex-shrink:0;}

        /* ── BADGES ── */
        .badge{display:inline-flex;align-items:center;gap:.28rem;font-size:.55rem;letter-spacing:.08em;text-transform:uppercase;padding:.18rem .55rem;border-radius:100px;font-weight:600;}
        .badge::before{content:'';width:4px;height:4px;border-radius:50%;flex-shrink:0;}
        .b-ok{background:rgba(22,163,74,.1);color:#15803d;border:1px solid rgba(22,163,74,.2);}
        .b-ok::before{background:#16a34a;}
        .b-pend{background:rgba(234,179,8,.1);color:#a16207;border:1px solid rgba(234,179,8,.2);}
        .b-pend::before{background:#ca8a04;}
        .b-cancel{background:rgba(220,38,38,.08);color:#dc2626;border:1px solid rgba(220,38,38,.18);}
        .b-cancel::before{background:#dc2626;}
        .b-gold{background:var(--gd);color:var(--gold);border:1px solid var(--gb);}
        .b-gold::before{background:var(--gold);}
        .b-blue{background:rgba(37,99,235,.08);color:#1d4ed8;border:1px solid rgba(37,99,235,.15);}
        .b-blue::before{background:#2563eb;}

        /* ── ACTION BTNS ── */
        .ab{display:inline-flex;align-items:center;gap:.28rem;padding:.28rem .65rem;border-radius:4px;font-size:.6rem;letter-spacing:.06em;text-transform:uppercase;border:1px solid transparent;cursor:pointer;font-family:'Inter',sans-serif;text-decoration:none;transition:all .12s;font-weight:500;}
        .ab svg{width:10px;height:10px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
        .ab-del{background:rgba(220,38,38,.07);color:#dc2626;border-color:rgba(220,38,38,.18);}
        .ab-del:hover{background:rgba(220,38,38,.13);}
        .ab-view{background:var(--gd);color:var(--gold);border-color:var(--gb);}
        .ab-view:hover{background:rgba(184,134,11,.14);}
        .ab-ok{background:rgba(22,163,74,.08);color:#15803d;border-color:rgba(22,163,74,.2);}
        .ab-ok:hover{background:rgba(22,163,74,.14);}

        /* ── FLASH ── */
        .flash{padding:.8rem 1.2rem;border-radius:6px;margin-bottom:1.4rem;font-size:.78rem;display:flex;align-items:center;gap:.5rem;}
        .flash svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0;}
        .f-ok{background:rgba(22,163,74,.08);border:1px solid rgba(22,163,74,.2);color:#15803d;}
        .f-info{background:rgba(234,179,8,.08);border:1px solid rgba(234,179,8,.2);color:#a16207;}

        .empty{text-align:center;padding:2.5rem;color:var(--c3);font-size:.78rem;}

        @media(max-width:900px){
            .sidebar{display:none;}
            .kpi-grid{grid-template-columns:1fr 1fr;}
        }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="s-logo">
        <a href="{{ route('home') }}">AUTO<span>LUX</span></a>
        <div class="s-badge">👑 Administrateur</div>
    </div>
    <nav class="s-nav">
        <div class="s-sec">Navigation</div>
        <a href="{{ route('admin.index') }}" class="s-link active">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="{{ route('voitures.index') }}" class="s-link">
            <svg viewBox="0 0 24 24"><path d="M19 17H5c-1.1 0-2-.9-2-2V7c0-1.1.9-2 2-2h14l3 4v6c0 1.1-.9 2-2 2z"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/></svg>
            Véhicules
        </a>
        <a href="{{ route('reservations.index') }}" class="s-link">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Réservations
        </a>
        <div class="s-sec">Site</div>
        <a href="{{ route('home') }}" class="s-link">
            <svg viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Voir le site
        </a>
    </nav>
    <div class="s-bottom">
        <div class="s-user">
            <div class="s-ava">{{ strtoupper(substr(Auth::user()->prenom ?? Auth::user()->nom, 0, 1)) }}</div>
            <div>
                <div class="s-uname">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                <div class="s-uemail">{{ Auth::user()->email }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="s-logout">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Se déconnecter
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="main">

    <div class="topbar">
        <div>
            <div class="tb-title">Tableau de bord</div>
            <div class="tb-sub">Bienvenue, {{ Auth::user()->prenom }} — {{ now()->format('d/m/Y') }}</div>
        </div>
        {{-- ✅ Bouton "Ajouter un véhicule" visible pour l'admin --}}
        <a href="{{ route('voitures.create') }}" class="tb-btn">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Ajouter un véhicule
        </a>
    </div>

    <div class="content">

        {{-- Flash --}}
        @if(session('success'))
        <div class="flash f-ok">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('info'))
        <div class="flash f-info">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('info') }}
        </div>
        @endif

        {{-- KPI --}}
        <div class="kpi-grid">
            <div class="kpi k-gold">
                <div class="kpi-ico"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <div class="kpi-val">{{ $totalUsers }}</div>
                <div class="kpi-lbl">Utilisateurs</div>
            </div>
            <div class="kpi k-green">
                <div class="kpi-ico"><svg viewBox="0 0 24 24"><path d="M19 17H5c-1.1 0-2-.9-2-2V7c0-1.1.9-2 2-2h14l3 4v6c0 1.1-.9 2-2 2z"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/></svg></div>
                <div class="kpi-val">{{ $totalVoitures }}</div>
                <div class="kpi-lbl">Véhicules</div>
            </div>
            <div class="kpi k-blue">
                <div class="kpi-ico"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                <div class="kpi-val">{{ $totalReservations }}</div>
                <div class="kpi-lbl">Réservations</div>
            </div>
            <div class="kpi k-red">
                <div class="kpi-ico"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                <div class="kpi-val">{{ number_format($totalRevenus, 0, ',', ' ') }}</div>
                <div class="kpi-lbl">Revenus MAD</div>
            </div>
        </div>

        {{-- TABS --}}
        <div class="tabs">
            <button class="tab active" onclick="showTab('reservations', this)">Réservations ({{ count($reservations) }})</button>
            <button class="tab" onclick="showTab('voitures', this)">Véhicules ({{ count($voitures) }})</button>
            <button class="tab" onclick="showTab('users', this)">Utilisateurs ({{ count($users) }})</button>
            <button class="tab" onclick="showTab('factures', this)">Factures ({{ count($factures) }})</button>
        </div>

        {{-- TAB : RÉSERVATIONS --}}
        <div class="panel active" id="tab-reservations">
            <div class="ph">
                <span class="ph-title">Toutes les réservations</span>
                <span class="ph-count">{{ count($reservations) }} au total</span>
            </div>
            @if($reservations->count())
            <table class="tbl">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Véhicule</th>
                        <th>Dates</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $r)
                    <tr>
                        <td style="color:var(--c3);font-size:.68rem;">{{ $r->id }}</td>
                        <td>
                            <span class="ava">{{ strtoupper(substr($r->user->prenom ?? $r->user->nom ?? 'C', 0, 1)) }}</span>
                            {{ $r->user->prenom ?? '—' }} {{ $r->user->nom ?? '' }}
                        </td>
                        <td>{{ $r->voiture->marque ?? '' }} {{ $r->voiture->modele ?? '—' }}</td>
                        <td style="font-size:.7rem;">
                            {{ \Carbon\Carbon::parse($r->date_debut)->format('d/m/Y') }}
                            <span style="color:var(--c3);">→</span>
                            {{ \Carbon\Carbon::parse($r->date_fin)->format('d/m/Y') }}
                        </td>
                        <td>{{ number_format($r->montant_total ?? 0, 0, ',', ' ') }} <span style="color:var(--c3);font-size:.65rem;">MAD</span></td>
                        <td>
                            @php $s = $r->statut ?? 'en attente'; @endphp
                            @if(in_array($s, ['confirmee','confirmée','confirmé']))
                                <span class="badge b-ok">Confirmée</span>
                            @elseif(in_array($s, ['annulee','annulée','annulé']))
                                <span class="badge b-cancel">Annulée</span>
                            @else
                                <span class="badge b-pend">En attente</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.reservations.cancel', $r) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="ab ab-del" onclick="return confirm('Annuler cette réservation ?')">
                                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    Annuler
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty">Aucune réservation pour l'instant.</div>
            @endif
        </div>

        {{-- TAB : VÉHICULES --}}
        <div class="panel" id="tab-voitures">
            <div class="ph">
                <span class="ph-title">Flotte de véhicules</span>
                <a href="{{ route('voitures.create') }}" class="tb-btn" style="font-size:.62rem;padding:.35rem .8rem;">+ Ajouter</a>
            </div>
            @if($voitures->count())
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Véhicule</th>
                        <th>Propriétaire</th>
                        <th>Prix/jour</th>
                        <th>Assurance</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($voitures as $v)
                    <tr>
                        <td>
                            <div style="font-weight:500;color:var(--cream);">{{ $v->marque }} {{ $v->modele }}</div>
                            <div style="font-size:.62rem;color:var(--c3);">{{ $v->categorie ?? '' }} · {{ $v->annee ?? '' }}</div>
                        </td>
                        <td>{{ $v->user->prenom ?? '—' }} {{ $v->user->nom ?? '' }}</td>
                        <td>{{ number_format($v->prix_journalier ?? $v->prix_par_jour ?? 0, 0, ',', ' ') }} MAD</td>
                        <td>
                            @if($v->assurance)
                                @if($v->assuranceValide())
                                    <span class="badge b-ok">Valide</span>
                                @else
                                    <span class="badge b-cancel">Expirée</span>
                                @endif
                            @else
                                <span class="badge b-pend">—</span>
                            @endif
                        </td>
                        <td>
                            @if($v->disponibilite)
                                <span class="badge b-ok">Disponible</span>
                            @else
                                <span class="badge b-cancel">Indisponible</span>
                            @endif
                        </td>
                        <td style="display:flex;gap:.3rem;">
                            <a href="{{ route('voitures.edit', $v) }}" class="ab ab-view">
                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Éditer
                            </a>
                            <form method="POST" action="{{ route('admin.voitures.delete', $v) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="ab ab-del" onclick="return confirm('Supprimer ce véhicule ?')">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty">Aucun véhicule enregistré.</div>
            @endif
        </div>

        {{-- TAB : UTILISATEURS --}}
        <div class="panel" id="tab-users">
            <div class="ph">
                <span class="ph-title">Tous les utilisateurs</span>
                <span class="ph-count">{{ count($users) }} comptes</span>
            </div>
            @if($users->count())
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td>
                            <span class="ava">{{ strtoupper(substr($u->prenom ?? $u->nom, 0, 1)) }}</span>
                            {{ $u->prenom }} {{ $u->nom }}
                        </td>
                        <td style="font-size:.72rem;">{{ $u->email }}</td>
                        <td>
                            @if($u->role === 'admin')
                                <span class="badge b-gold">👑 Admin</span>
                            @elseif($u->role === 'locataire')
                                <span class="badge b-blue">Locataire</span>
                            @else
                                <span class="badge b-ok">Client</span>
                            @endif
                        </td>
                        <td style="font-size:.7rem;">{{ $u->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($u->id !== Auth::id())
                            <form method="POST" action="{{ route('admin.users.delete', $u) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="ab ab-del" onclick="return confirm('Supprimer {{ $u->prenom }} ?')">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                    Supprimer
                                </button>
                            </form>
                            @else
                            <span style="font-size:.62rem;color:var(--c3);">Vous</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty">Aucun utilisateur.</div>
            @endif
        </div>

        {{-- TAB : FACTURES --}}
        <div class="panel" id="tab-factures">
            <div class="ph">
                <span class="ph-title">Factures émises</span>
                <span class="ph-count">{{ count($factures) }} factures</span>
            </div>
            @if($factures->count())
            <table class="tbl">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Véhicule</th>
                        <th>Date émission</th>
                        <th>Montant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factures as $f)
                    <tr>
                        <td style="color:var(--c3);font-size:.68rem;">{{ $f->id }}</td>
                        <td>
                            <span class="ava">{{ strtoupper(substr($f->reservation->user->prenom ?? 'C', 0, 1)) }}</span>
                            {{ $f->reservation->user->prenom ?? '—' }} {{ $f->reservation->user->nom ?? '' }}
                        </td>
                        <td>{{ $f->reservation->voiture->marque ?? '' }} {{ $f->reservation->voiture->modele ?? '—' }}</td>
                        <td style="font-size:.7rem;">{{ \Carbon\Carbon::parse($f->date_emission)->format('d/m/Y') }}</td>
                        <td>{{ number_format($f->montant_total, 0, ',', ' ') }} <span style="color:var(--c3);font-size:.65rem;">MAD</span></td>
                        <td style="display:flex;gap:.3rem;">
                            <a href="{{ route('factures.show', $f) }}" class="ab ab-view">
                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Voir
                            </a>
                            <a href="{{ route('factures.download', $f) }}" class="ab ab-ok">
                                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                PDF
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty">Aucune facture générée.</div>
            @endif
        </div>

    </div>{{-- /content --}}
</div>{{-- /main --}}

<script>
function showTab(name, btn) {
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>
</body>
</html>