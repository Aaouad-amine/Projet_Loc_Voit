{{-- resources/views/admin/vehicules/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Ajouter un véhicule')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Ajouter un véhicule</h2>
        <a href="{{ route('admin.vehicules.index') }}" class="btn btn-outline-secondary btn-sm">
            ← Retour à la liste
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.vehicules.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Informations du véhicule --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">Informations du véhicule</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Marque <span class="text-danger">*</span></label>
                        <input type="text" name="marque" class="form-control @error('marque') is-invalid @enderror"
                               value="{{ old('marque') }}" placeholder="ex: Mercedes, BMW...">
                        @error('marque') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Modèle <span class="text-danger">*</span></label>
                        <input type="text" name="modele" class="form-control @error('modele') is-invalid @enderror"
                               value="{{ old('modele') }}" placeholder="ex: Classe E, Série 5...">
                        @error('modele') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Année <span class="text-danger">*</span></label>
                        <input type="number" name="annee" class="form-control @error('annee') is-invalid @enderror"
                               value="{{ old('annee', date('Y')) }}" min="2000" max="{{ date('Y') + 1 }}">
                        @error('annee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Immatriculation <span class="text-danger">*</span></label>
                        <input type="text" name="immatriculation" class="form-control @error('immatriculation') is-invalid @enderror"
                               value="{{ old('immatriculation') }}" placeholder="ex: 12345-A-6">
                        @error('immatriculation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Couleur <span class="text-danger">*</span></label>
                        <input type="text" name="couleur" class="form-control @error('couleur') is-invalid @enderror"
                               value="{{ old('couleur') }}" placeholder="ex: Noir, Blanc...">
                        @error('couleur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Catégorie <span class="text-danger">*</span></label>
                        <select name="categorie" class="form-select @error('categorie') is-invalid @enderror">
                            <option value="">-- Sélectionner --</option>
                            @foreach(['Berline', 'SUV', 'Cabriolet', 'Utilitaire', 'Luxe'] as $cat)
                                <option value="{{ $cat }}" {{ old('categorie') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('categorie') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Photo du véhicule</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                               accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarification --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">Tarification</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Prix par jour (MAD) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="prix_par_jour" step="0.01" min="0"
                                   class="form-control @error('prix_par_jour') is-invalid @enderror"
                                   value="{{ old('prix_par_jour') }}" placeholder="0.00">
                            <span class="input-group-text">MAD</span>
                            @error('prix_par_jour') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Caution (MAD)</label>
                        <div class="input-group">
                            <input type="number" name="caution" step="0.01" min="0"
                                   class="form-control @error('caution') is-invalid @enderror"
                                   value="{{ old('caution', 0) }}">
                            <span class="input-group-text">MAD</span>
                            @error('caution') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statut & Notes --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">Disponibilité & statut</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Disponibilité <span class="text-danger">*</span></label>
                        <select name="disponibilite" class="form-select @error('disponibilite') is-invalid @enderror">
                            <option value="disponible"     {{ old('disponibilite','disponible') == 'disponible'     ? 'selected' : '' }}>Disponible</option>
                            <option value="en_location"    {{ old('disponibilite') == 'en_location'    ? 'selected' : '' }}>En location</option>
                            <option value="en_maintenance" {{ old('disponibilite') == 'en_maintenance' ? 'selected' : '' }}>En maintenance</option>
                        </select>
                        @error('disponibilite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kilométrage actuel</label>
                        <div class="input-group">
                            <input type="number" name="kilometrage" min="0"
                                   class="form-control @error('kilometrage') is-invalid @enderror"
                                   value="{{ old('kilometrage', 0) }}">
                            <span class="input-group-text">km</span>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Notes internes</label>
                        <textarea name="notes_internes" class="form-control @error('notes_internes') is-invalid @enderror"
                                  rows="3" placeholder="Notes visibles uniquement par l'admin...">{{ old('notes_internes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.vehicules.index') }}" class="btn btn-outline-secondary">Annuler</a>
            <button type="submit" class="btn btn-warning text-white fw-semibold px-4">
                + Ajouter le véhicule
            </button>
        </div>
    </form>
</div>
@endsection