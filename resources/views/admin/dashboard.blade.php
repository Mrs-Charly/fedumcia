<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administration
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm">{{ seeeion('status') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900">Bienvenue</h3>
                <p class="mt-2 text-sm text-gray-600">
                    Tableau de bord administrateur Fedumcia.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="{{ route('admin.appointments.index') }}"
                   class="block bg-white border rounded-lg p-6 hover:shadow-sm transition">
                    <div class="text-sm font-semibold text-gray-700">Rendez-vous</div>
                    <div class="mt-2 text-lg font-bold text-gray-900">Gestion RDV</div>
                    <p class="mt-3 text-sm text-gray-600">
                        Gérer les demandes, confirmations et annulations.
                    </p>
                    <div class="mt-6 text-sm font-semibold text-gray-900">
                        Ouvrir →
                    </div>
                </a>

                <a href="{{ route('admin.pack_requests.index') }}"
                   class="block bg-white border rounded-lg p-6 hover:shadow-sm transition">
                    <div class="text-sm font-semibold text-gray-700">Packs</div>
                    <div class="mt-2 text-lg font-bold text-gray-900">Demandes de pack</div>
                    <p class="mt-3 text-sm text-gray-600">
                        Approuver ou refuser les demandes clients.
                    </p>
                    <div class="mt-6 text-sm font-semibold text-gray-900">
                        Ouvrir →
                    </div>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="block bg-white border rounded-lg p-6 hover:shadow-sm transition">
                    <div class="text-sm font-semibold text-gray-700">Utilisateurs</div>
                    <div class="mt-2 text-lg font-bold text-gray-900">Gestion utilisateurs</div>
                    <p class="mt-3 text-sm text-gray-600">
                        Ajouter, modifier, supprimer, changer le pack.
                    </p>
                    <div class="mt-6 text-sm font-semibold text-gray-900">
                        Ouvrir →
                    </div>
                </a>
                <a href="{{ route('admin.packs.index') }}" class="block bg-white border rounded-lg p-6 hover:shadow transition">
                    <h4 class="font-semibold text-lg">Packs</h4>
                    <p class="mt-2 text-sm text-gray-600">
                        Créer, modifier, activer/désactiver et trier les packs.
                    </p>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="block bg-white border rounded-lg p-6 hover:shadow transition">
                    <h4 class="font-semibold text-lg">Avis</h4>
                    <p class="mt-2 text-sm text-gray-600">
                        Gérer les avis clients : approbation, masquage et suppression.
                    </p>
                </a>
                <a href="{{ route('admin.partners.index') }}"
                    class="block bg-white border rounded-lg p-6 hover:shadow transition">
                    <h4 class="font-semibold text-lg">Partenaires</h4>
                    <p class="mt-2 text-sm text-gray-600">Ajouter / modifier / désactiver les partenaires.</p>
                </a>
                <a href="{{ route('admin.stats.index') }}"
                    class="block bg-white border rounded-lg p-6 hover:shadow transition">
                    <h4 class="font-semibold text-lg">Statistiques</h4>
                    <p class="mt-2 text-sm text-gray-600">Voir les statistiques clés de la plateforme.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
