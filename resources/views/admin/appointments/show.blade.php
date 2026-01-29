<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rendez-vous #{{ $appointment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Informations générales --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                    <div>
                        <div class="text-gray-600">Entreprise</div>
                        <div class="font-semibold text-gray-900">
                            {{ $appointment->company_name ?? '—' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-gray-600">Date du rendez-vous</div>
                        <div class="font-semibold text-gray-900">
                            {{ $appointment->scheduled_at?->format('d/m/Y H:i') ?? '—' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-gray-600">Contact</div>
                        <div class="font-semibold text-gray-900">
                            {{ $appointment->first_name }} {{ $appointment->last_name }}
                        </div>
                        <div class="text-gray-600">{{ $appointment->email }}</div>
                        <div class="text-gray-600">{{ $appointment->phone }}</div>
                    </div>

                    <div>
                        <div class="text-gray-600">Statut</div>
                        <div class="font-semibold text-gray-900">
                            {{ ucfirst($appointment->status) }}
                        </div>
                        @if($appointment->confirmed_at)
                            <div class="text-gray-600">
                                Confirmé le {{ $appointment->confirmed_at->format('d/m/Y H:i') }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Adresse entreprise --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Adresse de l’entreprise</h3>

                <div class="text-sm text-gray-700 space-y-1">
                    <div>
                        <span class="text-gray-600">Adresse :</span>
                        {{ $appointment->company_address ?? '—' }}
                    </div>
                    <div>
                        <span class="text-gray-600">Code postal :</span>
                        {{ $appointment->company_postal_code ?? '—' }}
                    </div>
                    <div>
                        <span class="text-gray-600">Ville :</span>
                        {{ $appointment->company_city ?? '—' }}
                    </div>
                </div>
            </div>

            {{-- Pack souhaité --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Pack souhaité</h3>
                <div class="mt-2 text-sm">
                    <span class="font-semibold">
                        {{ $appointment->desiredPack?->name ?? 'Non précisé' }}
                    </span>
                </div>
            </div>

            {{-- RGPD --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">RGPD – Preuve de consentement</h3>
                <div class="mt-4 text-sm text-gray-700 space-y-1">
                    <div>Consentement : {{ $appointment->consent ? 'oui' : 'non' }}</div>
                    <div>Consentement le : {{ $appointment->consent_at?->format('d/m/Y H:i') ?? '—' }}</div>
                    <div>IP : {{ $appointment->consent_ip ?? '—' }}</div>
                    <div>User-Agent : {{ $appointment->consent_user_agent ?? '—' }}</div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Actions</h3>

                <a href="{{ route('admin.appointments.edit', $appointment) }}" class="inline-block px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                    Modifier le rendez-vous
                </a>


                @if($appointment->status !== 'cancelled')
                    <form method="POST"
                          action="{{ route('admin.appointments.cancel', $appointment) }}"
                          onsubmit="return confirm('Annuler ce rendez-vous ?')">
                        @csrf
                        <button class="mt-4 px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">
                            Annuler le rendez-vous
                        </button>
                    </form>
                @else
                    <p class="mt-4 text-sm text-gray-600">
                        Ce rendez-vous est déjà annulé.
                    </p>
                @endif
            </div>

            <div>
                <a href="{{ route('admin.appointments.index') }}"
                   class="text-sm text-gray-700 hover:text-gray-900">
                    ← Retour à la liste
                </a>
            </div>

            @if($appointment->user)
<div class="bg-white shadow-sm sm:rounded-lg p-6 mt-6">
    <h3 class="font-semibold text-lg">Changer le pack utilisateur</h3>

    <form method="POST"
          action="{{ route('admin.users.pack.update', $appointment->user) }}"
          class="mt-4 space-y-4">
        @csrf

        <div>
            <label class="text-sm text-gray-700">Pack actuel</label>
            <div class="mt-1 font-semibold">
                {{ $appointment->user->pack?->name ?? 'Aucun pack' }}
            </div>
        </div>

        <div>
            <label class="text-sm text-gray-700">Nouveau pack</label>
            <select name="pack_id" required class="mt-1 w-full border rounded-md p-2">
                <option value="">— Sélectionner —</option>
                @foreach(\App\Models\Pack::orderBy('sort_order')->get() as $pack)
                    <option value="{{ $pack->id }}">
                        {{ $pack->name }} — {{ $pack->price_eur }} €
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-700">Commentaire admin</label>
            <textarea name="message"
                      class="mt-1 w-full border rounded-md p-2"
                      rows="3"
                      placeholder="Motif du changement (optionnel)"></textarea>
        </div>

        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
            Appliquer le changement de pack
        </button>
    </form>
</div>
@endif

        </div>
    </div>
</x-app-layout>
