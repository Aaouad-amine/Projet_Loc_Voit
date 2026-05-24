<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AutoLouer — @yield('title', 'Location de Voitures')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@stack('styles')
<style>
/* ── Dropdown utilisateur ── */
.user-dropdown-toggle {
    display: flex;
    align-items: center;
    gap: .45rem;
    background: transparent;
    border: 1px solid rgba(212,160,23,.4);
    color: #D4A017;
    font-size: .7rem;
    letter-spacing: .15em;
    text-transform: uppercase;
    font-weight: 600;
    padding: .38rem .85rem;
    border-radius: 4px;
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
}
.user-dropdown-toggle:hover,
.user-dropdown-toggle.show {
    background: rgba(212,160,23,.12);
    border-color: #D4A017;
    color: #D4A017;
}
.user-dropdown-toggle .fa-chevron-down {
    font-size: .55rem;
    transition: transform .2s;
}
.user-dropdown-toggle.show .fa-chevron-down {
    transform: rotate(180deg);
}

.user-dd-menu {
    min-width: 230px;
    background: #1C1A16;
    border: 1px solid rgba(212,160,23,.2);
    border-radius: 6px;
    box-shadow: 0 16px 40px rgba(0,0,0,.5);
    padding: 0;
    overflow: hidden;
    margin-top: .4rem !important;
}

.dd-user-header {
    display: flex;
    align-items: center;
    gap: .7rem;
    padding: .9rem 1rem;
    background: rgba(255,255,255,.03);
}
.dd-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: rgba(212,160,23,.15);
    border: 1px solid rgba(212,160,23,.3);
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem; font-weight: 700; color: #D4A017;
    flex-shrink: 0;
}
.dd-uname  { font-size: .82rem; font-weight: 600; color: #FAF7F2; line-height: 1.2; }
.dd-uemail { font-size: .65rem; color: rgba(250,247,242,.35); word-break: break-all; }
.dd-urole  { font-size: .6rem;  color: rgba(212,160,23,.7); margin-top: .15rem; }

.dd-sep { height: 1px; background: rgba(255,255,255,.07); margin: 0; }

.dd-link {
    display: flex; align-items: center; gap: .65rem;
    padding: .68rem 1rem;
    color: rgba(250,247,242,.65);
    font-size: .78rem;
    text-decoration: none;
    transition: all .15s;
    background: none; border: none; width: 100%; text-align: left; cursor: pointer;
}
.dd-link i { width: 14px; text-align: center; opacity: .6; font-size: .78rem; }
.dd-link:hover { background: rgba(212,160,23,.08); color: #FAF7F2; }
.dd-link:hover i { opacity: 1; }
.dd-link.logout { color: rgba(220,38,38,.75); }
.dd-link.logout:hover { background: rgba(220,38,38,.08); color: #DC2626; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">🚗 AutoLouer</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('voitures.index') }}">Voitures</a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-center">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-2" href="{{ route('register') }}">S'inscrire</a>
                    </li>
                @else
                    {{-- Dropdown utilisateur --}}
                    <li class="nav-item dropdown">
                        <a class="user-dropdown-toggle dropdown-toggle"
                           href="#"
                           id="userDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{ strtoupper(Auth::user()->nom) }}
                            <i class="fa fa-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu user-dd-menu dropdown-menu-end" aria-labelledby="userDropdown">

                            {{-- En-tête profil --}}
                            <li>
                                <div class="dd-user-header">
                                    <div class="dd-avatar">
                                        {{ strtoupper(substr(Auth::user()->prenom ?? Auth::user()->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="dd-uname">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                                        <div class="dd-uemail">{{ Auth::user()->email }}</div>
                                        <div class="dd-urole">
                                            @if(Auth::user()->role === 'admin')
                                                👑 Administrateur
                                            @elseif(Auth::user()->role === 'locataire')
                                                🏢 Locataire
                                            @else
                                                🧑‍💼 Client
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li><div class="dd-sep"></div></li>

                            {{-- Liens selon le rôle --}}
                            @if(Auth::user()->role === 'admin')
                                <li>
<a class="dd-link" href="{{ route('admin.index') }}">                                        <i class="fa fa-gauge-high"></i> Dashboard Admin
                                    </a>
                                </li>
                                <li>
                                    <a class="dd-link" href="{{ route('voitures.index') }}">
                                        <i class="fa fa-car"></i> Gérer les voitures
                                    </a>
                                </li>
                            @elseif(Auth::user()->role === 'locataire')
                                <li>
                                    <a class="dd-link" href="{{ route('dashboard') }}">
                                        <i class="fa fa-gauge"></i> Mon tableau de bord
                                    </a>
                                </li>
                                <li>
                                    <a class="dd-link" href="{{ route('voitures.index') }}">
                                        <i class="fa fa-car"></i> Mes véhicules
                                    </a>
                                </li>
                                <li>
                                    <a class="dd-link" href="{{ route('reservations.index') }}">
                                        <i class="fa fa-calendar-check"></i> Réservations reçues
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dd-link" href="{{ route('dashboard') }}">
                                        <i class="fa fa-gauge"></i> Mon espace
                                    </a>
                                </li>
                                <li>
                                    <a class="dd-link" href="{{ route('reservations.index') }}">
                                        <i class="fa fa-calendar-check"></i> Mes réservations
                                    </a>
                                </li>
                            @endif

                            <li><div class="dd-sep"></div></li>

                            {{-- Déconnexion --}}
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dd-link logout">
                                        <i class="fa fa-right-from-bracket"></i> Se déconnecter
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* Rotation de la flèche au clic — Bootstrap s'occupe du toggle */
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('userDropdown');
    if (!toggle) return;
    toggle.addEventListener('show.bs.dropdown',  () => toggle.classList.add('show'));
    toggle.addEventListener('hide.bs.dropdown',  () => toggle.classList.remove('show'));
});
</script>

@stack('scripts')
</body>
</html>