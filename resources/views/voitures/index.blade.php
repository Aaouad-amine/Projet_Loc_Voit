<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Véhicules — AutoLux</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">🚗 Liste des véhicules</h1>

        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('voitures.create') }}"
                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold">
                    + Ajouter un véhicule
                </a>
            @endif
        @endauth
    </div>

    {{-- Flash success --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-4 mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Grille véhicules --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($voitures as $voiture)
        <div class="bg-white rounded-xl shadow p-4 flex flex-col">

            {{-- Image --}}
            @if($voiture->image)
                <img src="{{ Storage::url($voiture->image) }}"
                     class="w-full h-40 object-cover rounded-lg mb-3">
            @else
                <div class="w-full h-40 bg-gray-200 rounded-lg mb-3 flex items-center justify-center text-gray-400 text-sm">
                    📷 Pas de photo
                </div>
            @endif

            {{-- Infos --}}
            <h2 class="font-bold text-gray-800">{{ $voiture->marque }} {{ $voiture->modele }}</h2>
            <p class="text-gray-500 text-sm">{{ $voiture->annee }}</p>
            <p class="text-yellow-500 font-semibold mt-1">{{ $voiture->prix_par_jour }} MAD / jour</p>

            <span class="inline-block mt-2 px-2 py-1 rounded-full text-xs font-medium w-fit
                {{ $voiture->disponibilite ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $voiture->disponibilite ? '✅ Disponible' : '❌ Indisponible' }}
            </span>

            {{-- Boutons selon rôle --}}
            <div class="mt-4 flex gap-2">
                @auth
                    @if(Auth::user()->role === 'admin')
                        {{-- Admin : éditer + supprimer --}}
                        <a href="{{ route('voitures.edit', $voiture) }}"
                           class="flex-1 text-center border border-yellow-400 text-yellow-600 rounded-lg py-2 text-sm hover:bg-yellow-50 transition">
                            ✏️ Éditer
                        </a>
                        <form method="POST" action="{{ route('admin.voitures.delete', $voiture) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Supprimer ce véhicule ?')"
                                    class="border border-red-300 text-red-500 rounded-lg px-3 py-2 text-sm hover:bg-red-50 transition">
                                🗑
                            </button>
                        </form>

                    @elseif($voiture->disponibilite)
                        {{-- Client connecté : réserver --}}
                        <a href="{{ route('reservations.create', $voiture) }}"
                           class="flex-1 text-center bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg py-2 text-sm font-semibold transition">
                            📅 Réserver
                        </a>

                    @else
                        {{-- Indisponible --}}
                        <button disabled
                                class="flex-1 text-center bg-gray-200 text-gray-400 rounded-lg py-2 text-sm cursor-not-allowed">
                            ❌ Non disponible
                        </button>
                    @endif

                @else
                    {{-- Non connecté --}}
                    <a href="{{ route('login') }}"
                       class="flex-1 text-center bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg py-2 text-sm font-semibold transition">
                        🔑 Connectez-vous pour réserver
                    </a>
                @endauth
            </div>

        </div>
        @empty
            <p class="text-gray-400 col-span-3 text-center py-10">Aucun véhicule pour l'instant.</p>
        @endforelse
    </div>

</div>
</body>
</html>