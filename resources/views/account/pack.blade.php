<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mon pack
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm text-gray-800">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Pack actuel --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-sm text-gray-600">Pack actuel</div>
                <div class="mt-2 text-xl font-bold">
                    {{ $user->pack?->name ?? 'Aucun pack' }}
                </div>
                @if($user->pack)
                    <div class="mt-2 text-gray-700">
                        {{ $user->pack->price_eur }}€ — {{ $user->pack->tagline }}
                    </div>
                @else
                    <p class="mt-2 text-sm text-gray-600">
                        Vous n’avez pas encore sélectionné de pack. Vous pouvez en faire la demande ci-dessous.
                    </p>
                @endif
            </div>

            {{-- Demande en attente --}}
            @if(!empty($pendingRequest))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-yellow-200">
                    <div class="text-sm text-gray-600">Demande de changement</div>
                    <div class="mt-2 text-lg font-bold text-gray-900">En attente de validation</div>

                    <div class="mt-3 text-sm text-gray-700">
                        Pack demandé :
                        <span class="font-semibold">
                            {{ $pendingRequest->requestedPack?->name ?? 'Aucun pack' }}
                        </span>
                    </div>

                    <div class="mt-2 text-xs text-gray-500">
                        Envoyée le {{ $pendingRequest->created_at->format('d/m/Y H:i') }}
                    </div>

                    @if($pendingRequest->message)
                        <div class="mt-4 text-sm text-gray-700">
                            <div class="text-xs text-gray-500">Votre message :</div>
                            <div class="mt-1">{{ $pendingRequest->message }}</div>
                        </div>
                    @endif

                    <div class="mt-4 text-sm text-gray-600">
                        Fedumcia validera votre demande après étude (généralement pendant ou suite au rendez-vous).
                    </div>
                </div>
            @else
                {{-- Formulaire de demande (pas de changement direct) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-lg">Demander un changement de pack</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Vous ne changez pas votre pack automatiquement : une validation Fedumcia est nécessaire.
                    </p>

                    <form method="POST" action="{{ route('pack.update') }}" class="mt-4 space-y-4">
                        @csrf

                        <div>
                            <label class="text-sm text-gray-700">Pack souhaité</label>
                            <select name="requested_pack_id" class="mt-1 w-full border rounded-md p-2">
                                <option value="">Aucun pack</option>
                                @foreach($packs as $pack)
                                    <option value="{{ $pack->id }}">
                                        {{ $pack->name }} — {{ $pack->price_eur }}€
                                    </option>
                                @endforeach
                            </select>
                            @error('requested_pack_id')
                                <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Message (optionnel)</label>
                            <textarea
                                name="message"
                                rows="3"
                                class="mt-1 w-full border rounded-md p-2"
                                placeholder="Ex : je souhaite passer sur Croissance pour augmenter ma visibilité..."
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                            Envoyer la demande
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
