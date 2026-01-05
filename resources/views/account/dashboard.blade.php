<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mon compte
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Résumé --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-sm text-gray-600">Bienvenue</div>
                <div class="mt-1 text-xl font-bold text-gray-900">{{ $user->name }}</div>
                <div class="mt-1 text-sm text-gray-600">{{ $user->email }}</div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-md border bg-white hover:bg-gray-50 text-sm">
                        Modifier mes informations
                    </a>
                    <a href="{{ route('pack.edit') }}" class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800 text-sm">
                        Choisir / changer de pack
                    </a>
                </div>
            </div>

            {{-- Pack --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-sm text-gray-600">Pack actuel</div>
                <div class="mt-2 text-2xl font-bold text-gray-900">
                    {{ $user->pack?->name ?? 'Aucun pack sélectionné' }}
                </div>

                @if($user->pack)
                    <div class="mt-2 text-gray-700">
                        {{ $user->pack->price_eur }}€ — {{ $user->pack->tagline }}
                    </div>
                @else
                    <p class="mt-2 text-sm text-gray-600">
                        Vous pourrez valider votre pack pendant le rendez-vous avec Fedumcia.
                    </p>
                @endif
            </div>

            {{-- Rendez-vous --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-lg font-semibold text-gray-900">Mes rendez-vous</h3>
                    <a href="{{ route('home') }}#rdv" class="text-sm text-gray-700 hover:text-gray-900">
                        Prendre un nouveau rendez-vous →
                    </a>
                </div>

                @if($appointments->isEmpty())
                    <p class="mt-4 text-sm text-gray-600">Aucun rendez-vous pour le moment.</p>
                @else
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-600 border-b">
                                <tr>
                                    <th class="py-2 pr-4">Date</th>
                                    <th class="py-2 pr-4">Entreprise</th>
                                    <th class="py-2 pr-4">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($appointments as $a)
                                    <tr>
                                        <td class="py-3 pr-4 text-gray-900">
                                            {{ $a->scheduled_at?->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="py-3 pr-4 text-gray-700">
                                            {{ $a->company_name }}
                                        </td>
                                        <td class="py-3 pr-4">
                                            @php
                                                $label = match($a->status) {
                                                    'confirmed' => 'Confirmé',
                                                    'pending' => 'En attente',
                                                    'cancelled' => 'Annulé',
                                                    default => $a->status,
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-1 rounded-md border text-xs text-gray-700">
                                                {{ $label }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
