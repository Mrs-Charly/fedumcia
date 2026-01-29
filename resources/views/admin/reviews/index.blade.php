<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Avis</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" class="flex flex-col md:flex-row gap-3 md:items-end">
                    <div class="flex-1">
                        <label class="text-sm text-gray-700">Recherche</label>
                        <input name="q" value="{{ $q }}" class="mt-1 w-full border rounded-md p-2" placeholder="Nom, entreprise, contenu..." />
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Statut</label>
                        <select name="status" class="mt-1 w-full border rounded-md p-2">
                            <option value="">Tous</option>
                            <option value="pending" @selected($status === 'pending')>En attente</option>
                            <option value="approved" @selected($status === 'approved')>Approuvés</option>
                            <option value="hidden" @selected($status === 'hidden')>Masqués</option>
                        </select>
                    </div>

                    <div>
                        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-600 border-b">
                        <tr>
                            <th class="py-2 pr-4">Date</th>
                            <th class="py-2 pr-4">Auteur</th>
                            <th class="py-2 pr-4">Note</th>
                            <th class="py-2 pr-4">Statut</th>
                            <th class="py-2 pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($reviews as $r)
                            <tr>
                                <td class="py-3 pr-4">{{ $r->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 pr-4">
                                    <div class="font-medium text-gray-900">{{ $r->name }}</div>
                                    <div class="text-gray-600">{{ $r->company ?? '—' }}</div>
                                    <div class="text-gray-600 line-clamp-2">{{ $r->comment }}</div>
                                </td>
                                <td class="py-3 pr-4">{{ $r->rating }}/5</td>
                                <td class="py-3 pr-4">
                                    @if(!$r->is_visible)
                                        <span class="inline-flex px-2 py-1 rounded bg-gray-100 text-gray-800">masqué</span>
                                    @elseif($r->is_approved)
                                        <span class="inline-flex px-2 py-1 rounded bg-gray-900 text-white">approuvé</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 rounded bg-gray-100 text-gray-800">en attente</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-4 flex items-center gap-3">
                                    @if($r->is_visible && !$r->is_approved)
                                        <form method="POST" action="{{ route('admin.reviews.approve', $r) }}">
                                            @csrf
                                            <button class="text-gray-900 hover:underline">Approuver</button>
                                        </form>
                                    @endif

                                    @if($r->is_visible)
                                        <form method="POST" action="{{ route('admin.reviews.hide', $r) }}">
                                            @csrf
                                            <button class="text-gray-700 hover:underline">Masquer</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.reviews.destroy', $r) }}" onsubmit="return confirm('Supprimer cet avis ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
