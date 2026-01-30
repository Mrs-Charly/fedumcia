<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Statistiques
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" class="flex flex-col md:flex-row gap-3 md:items-end">
                    <div>
                        <label class="text-sm text-gray-700">Du</label>
                        <input type="date" name="from" value="{{ $from }}" class="mt-1 w-full border rounded-md p-2" />
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Au</label>
                        <input type="date" name="to" value="{{ $to }}" class="mt-1 w-full border rounded-md p-2" />
                    </div>

                    <div>
                        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                            Appliquer
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- RDV --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">Rendez-vous (période)</div>
                    <div class="mt-2 text-3xl font-extrabold text-gray-900">{{ $appointmentsTotal }}</div>

                    <div class="mt-4 text-sm text-gray-700 space-y-1">
                        <div>En attente : <span class="font-semibold">{{ $appointmentsPending }}</span></div>
                        <div>Confirmés : <span class="font-semibold">{{ $appointmentsConfirmed }}</span></div>
                        <div>Annulés : <span class="font-semibold">{{ $appointmentsCancelled }}</span></div>
                    </div>
                </div>

                {{-- Avis --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">Avis (période)</div>
                    <div class="mt-2 text-3xl font-extrabold text-gray-900">{{ $reviewsTotal }}</div>

                    <div class="mt-4 text-sm text-gray-700 space-y-1">
                        <div>En attente : <span class="font-semibold">{{ $reviewsPending }}</span></div>
                        <div>Approuvés : <span class="font-semibold">{{ $reviewsApproved }}</span></div>
                        <div>Masqués : <span class="font-semibold">{{ $reviewsHidden }}</span></div>
                    </div>
                </div>

                {{-- Packs --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-600">Packs</div>
                    <div class="mt-2 text-3xl font-extrabold text-gray-900">{{ $packsActive }}</div>
                    <div class="mt-1 text-sm text-gray-600">actifs ({{ $packsTotal }} au total)</div>
                </div>

            </div>

            {{-- Top packs demandés --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Top packs demandés (via RDV)</h3>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-600 border-b">
                            <tr>
                                <th class="py-2 pr-4">Pack</th>
                                <th class="py-2 pr-4">Demandes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($topRequestedPacks as $row)
                                <tr>
                                    <td class="py-3 pr-4 font-medium text-gray-900">
                                        {{ $row->desiredPack?->name ?? 'Pack supprimé' }}
                                    </td>
                                    <td class="py-3 pr-4">{{ $row->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-3 pr-4 text-gray-600" colspan="2">
                                        Aucun rendez-vous avec pack sur la période.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
