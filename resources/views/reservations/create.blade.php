@extends('layouts.app')

@section('title', 'Réserver - ' . $voiture->marque . ' ' . $voiture->modele)

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow border-0 rounded-4">

            <div class="card-header text-white py-3 rounded-top-4"
                 style="background:#1a2e44;">

                <h5 class="mb-0">
                    <i class="fas fa-calendar-plus me-2"></i>

                    Réserver :
                    {{ $voiture->marque }}
                    {{ $voiture->modele }}
                </h5>
            </div>

            <div class="card-body p-4">

                {{-- Informations voiture --}}
                <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3"
                     style="background:#f0f9ff;">

                    <div class="fs-2">🚗</div>

                    <div>
                        <strong>
                            {{ $voiture->marque }}
                            {{ $voiture->modele }}
                            ({{ $voiture->annee }})
                        </strong>

                        <br>

                        <span class="text-muted">
                            {{ $voiture->carburant }}
                            ·
                            {{ $voiture->transmission }}
                        </span>

                        <br>

                        <strong style="color:#00b4d8;">
                            {{ number_format($voiture->prix_par_jour, 0) }}
                            MAD / jour
                        </strong>
                    </div>
                </div>

                {{-- Formulaire --}}
                <form method="POST"
                      action="{{ route('reservations.store', $voiture) }}">

                    @csrf

                    {{-- Date début --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Date de début *
                        </label>

                        <input
                            type="date"
                            name="date_debut"
                            id="date-debut"

                            class="form-control form-control-lg @error('date_debut') is-invalid @enderror"

                            min="{{ now()->toDateString() }}"
                            value="{{ old('date_debut') }}"
                            required
                        >

                        @error('date_debut')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Date fin --}}
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Date de fin *
                        </label>

                        <input
                            type="date"
                            name="date_fin"
                            id="date-fin"

                            class="form-control form-control-lg @error('date_fin') is-invalid @enderror"

                            min="{{ now()->addDay()->toDateString() }}"
                            value="{{ old('date_fin') }}"
                            required
                        >

                        @error('date_fin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Zone calcul --}}
                    <div
                        class="alert alert-info d-none rounded-3 mb-4"
                        id="calcul-zone"
                    >

                        <div class="d-flex justify-content-between mb-1">
                            <span>Prix / jour</span>

                            <strong>
                                {{ number_format($voiture->prix_par_jour, 0) }}
                                MAD
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mb-1">
                            <span>Nombre de jours</span>

                            <strong id="nb-jours">—</strong>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex justify-content-between fs-5">

                            <span class="fw-bold">
                                Total estimé
                            </span>

                            <strong
                                id="total-montant"
                                style="color:#00b4d8;"
                            >
                                —
                            </strong>
                        </div>
                    </div>

                    {{-- Boutons --}}
                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-lg text-white fw-bold rounded-3"
                            style="background:#00b4d8;"
                        >
                            <i class="fas fa-check-circle me-2"></i>

                            Confirmer la réservation
                        </button>

                        <a
                            href="{{ route('voitures.show', $voiture) }}"
                            class="btn btn-lg btn-outline-secondary rounded-3"
                        >
                            Annuler
                        </a>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')

<script>

const prixJour = @json($voiture->prix_par_jour);

const dateDebut = document.getElementById('date-debut');
const dateFin   = document.getElementById('date-fin');

dateDebut.addEventListener('change', calcTotal);
dateFin.addEventListener('change', calcTotal);

function calcTotal()
{
    const d = dateDebut.value;
    const f = dateFin.value;

    if (!d || !f) {
        return;
    }

    const debut = new Date(d);
    const fin   = new Date(f);

    const jours = Math.ceil(
        (fin - debut) / 86400000
    );

    if (jours <= 0) {
        return;
    }

    document.getElementById('nb-jours').textContent =
        jours + ' jour(s)';

    document.getElementById('total-montant').textContent =
        (jours * prixJour).toLocaleString() + ' MAD';

    document.getElementById('calcul-zone')
        .classList.remove('d-none');
}

</script>

@endpush