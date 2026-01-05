<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Demandes de changement de pack
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-600 border-b">
                        <tr>
                            <th class="py-2 pr-4">Date</th>
                            <th class="py-2 pr-4">Utilisateur</th>
                            <th class="py-2 pr-4">Pack demandé</th>
                            <th class="py-2 pr-4">Statut</th>
                            <th class="py-2 pr-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($requests as $r)
                            <tr>
                                <td class="py-3 pr-4">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3 pr-4">
                                    {{ $r->user->name }}<br>
                                    <span class="text-gray-600">{{ $r->user->email }}</span>
                                </td>
                                <td class="py-3 pr-4">
                                    {{ $r->requestedPack?->name ?? 'Aucun pack' }}
                                </td>
                                <td class="py-3 pr-4">{{ $r->status }}</td>
                                <td class="py-3 pr-4">
                                    @if($r->status === 'pending')
                                        <form class="inline" method="POST" action="{{ route('admin.pack_requests.approve', $r) }}">
                                            @csrf
                                            <button class="px-3 py-1 rounded-md bg-green-600 text-white text-xs">Approuver</button>
                                        </form>
                                        <form class="inline" method="POST" action="{{ route('admin.pack_requests.reject', $r) }}">
                                            @csrf
                                            <button class="px-3 py-1 rounded-md bg-red-600 text-white text-xs">Refuser</button>
                                        </form>
                                    @else
                                        <span class="text-gray-600 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                            @if($r->message)
                                <tr>
                                    <td></td>
                                    <td colspan="4" class="py-2 text-gray-700">
                                        <span class="text-gray-500">Message :</span> {{ $r->message }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
