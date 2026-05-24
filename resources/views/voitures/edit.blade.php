@extends('layouts.app')
@section('title', 'Modifier la voiture')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0 rounded-4">
            <div class="card-header text-white py-3 rounded-top-4" style="background:#1a2e44;">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Modifier : {{ $voiture->marque }} {{ $voiture->modele }}
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('voitures.update', $voiture) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing:1px;">
                        <i class="fas fa-info-circle me-1" style="color:#00b4d8;"></i> Informations générales
                    </h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Marque *</label>
                            <input type="text" name="marque"
                                   class="form-control @error('marque') is-invalid @enderror"
                                   value="{{ old('marque', $voiture->marque) }}" required>
                            @error('marque')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Modèle *</label>
                            <input type="text" name="modele"
                                   class="form-control @error('modele') is-invalid @enderror"
                                   value="{{ old('modele', $voiture->modele) }}" required>
                            @error('modele')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Année *</label>
                            <input type="number" name="annee"
                                   class="form-control @error('annee') is-invalid @enderror"
                                   value="{{ old('annee', $voiture->annee) }}" min="1990" max="{{ date('Y') }}" required>
                            @error('annee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Carburant *</label>
                            <select name="carburant" class="form-select" required>
                                @foreach(['Essence','Diesel','Hybride','Électrique'] as $c)
                                    <option value="{{ $c }}" {{ old('carburant', $voiture->carburant)===$c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Transmission *</label>
                            <select name="transmission" class="form-select" required>
                                <option value="Manuelle" {{ old('transmission', $voiture->transmission)==='Manuelle' ? 'selected' : '' }}>Manuelle</option>
                                <option value="Automatique" {{ old('transmission', $voiture->transmission)==='Automatique' ? 'selected' : '' }}>Automatique</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Prix par jour (MAD) *</label>
                            <div class="input-group">
                                <input type="number" name="prix_par_jour"
                                       class="form-control @error('prix_par_jour') is-invalid @enderror"
                                       value="{{ old('prix_par_jour', $voiture->prix_par_jour) }}" min="1" step="0.01" required>
                                <span class="input-group-text">MAD</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Photo (laisser vide pour conserver)</label>
                            <input type="file" name="image" accept="image/*" class="form-control">
                            @if($voiture->image)
                                <small class="text-muted">Photo actuelle : <em>{{ $voiture->image }}</em></small>
                            @endif
                        </div>
                    </div>

                    @if($voiture->assurance)
                    <hr class="my-4">
                    <h6 class="fw-bold text-muted text-uppercase mb-3" style="letter-spacing:1px;">
                        <i class="fas fa-shield-alt me-1" style="color:#00b4d8;"></i> Assurance
                    </h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Type d'assurance</label>
                            <input type="text" name="type_assurance" class="form-control"
                                   value="{{ old('type_assurance', $voiture->assurance->type_assurance) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Numéro de police</label>
                            <input type="text" name="numero_police" class="form-control"
                                   value="{{ old('numero_police', $voiture->assurance->numero_police) }}">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date début</label>
                            <input type="date" name="date_debut_assur" class="form-control"
                                   value="{{ old('date_debut_assur', $voiture->assurance->date_debut) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date fin</label>
                            <input type="date" name="date_fin_assur" class="form-control"
                                   value="{{ old('date_fin_assur', $voiture->assurance->date_fin) }}">
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-lg text-white fw-bold px-5 rounded-3"
                                style="background:#00b4d8;">
                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-lg btn-outline-secondary rounded-3">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection