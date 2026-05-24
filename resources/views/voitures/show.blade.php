@extends('layouts.app')
@section('title', $voiture->marque . ' ' . $voiture->modele)
@section('content')
<div class="row">
    <div class="col-md-7">
        @if($voiture->image)
            <img src="{{ Storage::url($voiture->image) }}" class="img-fluid rounded mb-3" alt="{{ $voiture->marque }}">
        @else
            <div class="bg-secondary rounded text-center py-5 mb-3 fs-1 text-white">🚗</div>
        @endif
        <h2>{{ $voiture->marque }} {{ $voiture->modele }}</h2>
        <div class="d-flex gap-2 flex-wrap mt-2 mb-3">
            <span class="badge bg-secondary">📅 {{ $voiture->annee }}</span>
            <span class="badge bg-secondary">⛽ {{ $voiture->carburant }}</span>
            <span class="badge bg-secondary">⚙️ {{ $voiture->transmission }}</span>
            <span class="badge {{ $voiture->disponibilite ? 'bg-success' : 'bg-danger' }}">
                {{ $voiture->disponibilite ? '✅ Disponible' : '❌ Indisponible' }}
            </span>
        </div>
        @if($voiture->assurance)
        <div class="alert {{ $voiture->assuranceValide() ? 'alert-success' : 'alert-danger' }}">
            🛡️ Assurance {{ $voiture->assurance->type_assurance }}
            · Police : {{ $voiture->assurance->numero_police }}
            · Valide jusqu'au {{ $voiture->assurance->date_fin }}
        </div>
        @endif
        <p class="text-muted">Proposé par : <strong>{{ $voiture->user->prenom }} {{ $voiture->user->nom }}</strong></p>
    </div>

    <div class="col-md-5">
        <div class="card shadow sticky-top" style="top:80px">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">💰 {{ number_format($voiture->prix_par_jour, 0) }} MAD / jour</h5>
            </div>
            <div class="card-body">
                @auth
                    @if($voiture->disponibilite && $voiture->assuranceValide())
                        <form method="POST" action="{{ route('reservations.store', $voiture) }}" id="form-resa">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date de début</label>
                                <input type="date" name="date_debut" id="date-debut" class="form-control" min="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date de fin</label>
                                <input type="date" name="date_fin" id="date-fin" class="form-control" min="{{ now()->addDay()->toDateString() }}" required>
                            </div>
                            <div class="alert alert-info d-none" id="calcul-zone">
                                <div class="d-flex justify-content-between"><span>Prix/jour</span><strong>{{ $voiture->prix_par_jour }} MAD</strong></div>
                                <div class="d-flex justify-content-between"><span>Nombre de jours</span><strong id="nb-jours">—</strong></div>
                                <hr>
                                <div class="d-flex justify-content-between fs-5"><span>Total</span><strong id="total-montant" class="text-primary">—</strong></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">✅ Confirmer la réservation</button>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            {{ !$voiture->disponibilite ? 'Voiture non disponible.' : 'Assurance expirée.' }}
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Connectez-vous pour réserver</a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
const prixJour = {{ $voiture->prix_par_jour }};
['date-debut','date-fin'].forEach(id => {
    document.getElementById(id).addEventListener('change', calcTotal);
});
function calcTotal() {
    const d = document.getElementById('date-debut').value;
    const f = document.getElementById('date-fin').value;
    if (!d || !f) return;
    const jours = Math.ceil((new Date(f) - new Date(d)) / 86400000);
    if (jours <= 0) return;
    document.getElementById('nb-jours').textContent = jours + ' jour(s)';
    document.getElementById('total-montant').textContent = (jours * prixJour) + ' MAD';
    document.getElementById('calcul-zone').classList.remove('d-none');
}
</script>
@endpush