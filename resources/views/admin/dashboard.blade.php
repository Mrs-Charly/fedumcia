<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administration
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold">Bienvenue</h3>
                <p class="mt-2 text-sm text-gray-600">
                    Tableau de bord administrateur Fedumcia.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Rendez-vous --}}
                <a href="{{ route('admin.appointments.index') }}"
                   class="block bg-white border rounded-lg p-6 hover:shadow transition">
                    <h4 class="font-semibold text-lg">Rendez-vous</h4>
                    <p class="mt-2 text-sm text-gray-600">
                        Gérer les demandes de rendez-vous, confirmations et annulations.
                    </p>
                </a>

                {{-- Demandes de pack --}}
                <a href="{{ route('admin.pack_requests.index') }}"
                   class="block bg-white border rounded-lg p-6 hover:shadow transition">
                    <h4 class="font-semibold text-lg">Demandes de changement de pack</h4>
                    <p class="mt-2 text-sm text-gray-600">
                        Approuver ou refuser les demandes clients.
                    </p>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
