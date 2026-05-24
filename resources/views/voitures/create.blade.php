<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un véhicule — AutoLux</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">

<div class="bg-white rounded-2xl shadow-lg w-full max-w-2xl p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Ajouter un véhicule</h1>
            <p class="text-gray-500 text-sm mt-1">Remplissez les informations du véhicule</p>
        </div>
        <a href="{{ url()->previous() }}" class="text-gray-400 hover:text-gray-600 transition">✕</a>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <ul class="text-red-600 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
    <form action="{{ route('voitures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Marque & Modèle --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Marque *</label>
                <input type="text" name="marque" value="{{ old('marque') }}"
                       placeholder="Ex: Toyota"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('marque') border-red-400 @enderror">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modèle *</label>
                <input type="text" name="modele" value="{{ old('modele') }}"
                       placeholder="Ex: Corolla"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('modele') border-red-400 @enderror">
            </div>
        </div>

        {{-- Année & Prix --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Année *</label>
                <input type="number" name="annee" value="{{ old('annee') }}"
                       placeholder="Ex: 2022" min="1990" max="{{ date('Y') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('annee') border-red-400 @enderror">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix / jour (MAD) *</label>
                <input type="number" name="prix_journalier" value="{{ old('prix_journalier') }}"
                       placeholder="Ex: 350" min="1"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('prix_journalier') border-red-400 @enderror">
            </div>
        </div>

        {{-- Disponibilité --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Disponibilité *</label>
            <select name="disponibilite"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <option value="1" {{ old('disponibilite') == '1' ? 'selected' : '' }}>✅ Disponible</option>
                <option value="0" {{ old('disponibilite') == '0' ? 'selected' : '' }}>❌ Non disponible</option>
            </select>
        </div>

        {{-- Séparateur Assurance --}}
        <div class="border-t border-gray-200 pt-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">🛡️ Informations d'assurance</h2>
        </div>

        {{-- Type assurance & Numéro police --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type d'assurance *</label>
                <select name="type_assurance"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('type_assurance') border-red-400 @enderror">
                    <option value="">-- Choisir --</option>
                    <option value="tous_risques"  {{ old('type_assurance') == 'tous_risques'  ? 'selected' : '' }}>Tous risques</option>
                    <option value="tiers"         {{ old('type_assurance') == 'tiers'         ? 'selected' : '' }}>Au tiers</option>
                    <option value="standard"      {{ old('type_assurance') == 'standard'      ? 'selected' : '' }}>Standard</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de police *</label>
                <input type="text" name="numero_police" value="{{ old('numero_police') }}"
                       placeholder="Ex: POL-2024-001"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('numero_police') border-red-400 @enderror">
            </div>
        </div>

        {{-- Date début & Date fin assurance --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date début assurance *</label>
                <input type="date" name="date_debut" value="{{ old('date_debut', now()->toDateString()) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('date_debut') border-red-400 @enderror">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date fin assurance *</label>
                <input type="date" name="date_expiration" value="{{ old('date_expiration') }}"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('date_expiration') border-red-400 @enderror">
            </div>
        </div>

        {{-- Image --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Photo du véhicule</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-yellow-400 transition cursor-pointer"
                 onclick="document.getElementById('image').click()">
                <input type="file" id="image" name="image" accept="image/*" class="hidden"
                       onchange="previewImage(event)">
                <div id="preview-container">
                    <p class="text-gray-400 text-sm">📷 Cliquez pour ajouter une photo</p>
                    <p class="text-gray-300 text-xs mt-1">JPEG, PNG — max 2MB</p>
                </div>
                <img id="preview-img" src="" alt="" class="hidden mx-auto max-h-40 rounded-lg mt-2">
            </div>
        </div>

        {{-- Boutons --}}
        <div class="flex gap-3 pt-2">
            <a href="{{ url()->previous() }}"
               class="flex-1 text-center border border-gray-300 text-gray-600 rounded-lg py-2.5 hover:bg-gray-50 transition">
                Annuler
            </a>
            <button type="submit"
                    class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-lg py-2.5 transition">
                ＋ Ajouter le véhicule
            </button>
        </div>

    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('preview-img').classList.remove('hidden');
            document.getElementById('preview-container').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>

</body>
</html>