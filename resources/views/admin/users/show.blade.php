<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Utilisateur #{{ $user->id }}
            </h2>

            <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                Éditer
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="text-sm text-gray-600">Nom</div>
                <div class="font-semibold text-gray-900">{{ $user->name }}</div>

                <div class="mt-4 text-sm text-gray-600">Email</div>
                <div class="font-semibold text-gray-900">{{ $user->email }}</div>

                <div class="mt-4 text-sm text-gray-600">Adresse</div>
                
                <div class="font-semibold text-gray-900">
                    @php
                    $addr = trim(($user->address_line1 ?? '') . ' ' . ($user->address_postal_code ?? '') . ' ' . ($user->address_city ?? ''));
                    @endphp
                    {{ $addr !== '' ? $addr : '—' }}
                </div>

                <div class="mt-4 text-sm text-gray-600">Rôle</div>
                <div class="font-semibold text-gray-900">{{ $user->is_admin ? 'admin' : 'utilisateur' }}</div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Pack</h3>

                <div class="mt-2 text-sm text-gray-600">Pack actuel</div>
                <div class="font-semibold text-gray-900">{{ $user->pack?->name ?? 'Aucun pack' }}</div>

                <form method="POST" action="{{ route('admin.users.pack.update', $user) }}" class="mt-4 space-y-3">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-sm text-gray-700">Changer le pack</label>
                        <select name="pack_id" class="mt-1 w-full border rounded-md p-2">
                            <option value="">Aucun pack</option>
                            @foreach($packs as $pack)
                                <option value="{{ $pack->id }}" @selected($user->pack_id === $pack->id)>
                                    {{ $pack->name }} — {{ $pack->price_eur }}€
                                </option>
                            @endforeach
                        </select>

                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
    <h3 class="font-semibold text-lg">Historique packs</h3>

    <div class="mt-4 space-y-3 text-sm">
        @forelse($user->packChangeRequests as $r)
            <div class="border rounded p-3">
                <div class="font-semibold">
                    {{ $r->status }} — {{ $r->created_at?->format('d/m/Y H:i') }}
                </div>
                <div class="text-gray-700">
                    De: {{ $r->currentPack?->name ?? 'Aucun' }}
                    → Vers: {{ $r->requestedPack?->name ?? 'Aucun' }}
                </div>
                <div class="text-gray-600">
                    Source: {{ $r->source ?? '—' }}
                </div>
                @if($r->message)
                    <div class="text-gray-600">{{ $r->message }}</div>
                @endif
            </div>
        @empty
            <div class="text-gray-600">Aucun historique.</div>
        @endforelse
    </div>
</div>


                        @error('pack_id')
                            <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                        Enregistrer
                    </button>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Suppression</h3>

                @if(!$user->is_admin)
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                        @csrf
                        @method('DELETE')

                        <button class="mt-3 px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">
                            Supprimer l’utilisateur
                        </button>
                    </form>
                @else
                    <p class="mt-3 text-sm text-gray-600">Suppression désactivée pour un administrateur.</p>
                @endif
            </div>

            <div>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-700 hover:text-gray-900">← Retour</a>
            </div>
        </div>
    </div>
</x-app-layout>
