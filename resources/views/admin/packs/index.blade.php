<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Packs</h2>
            <a href="{{ route('admin.packs.create') }}" class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                + Nouveau pack
            </a>
        </div>
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
                        <input name="q" value="{{ $q ?? request('q') }}" class="mt-1 w-full border rounded-md p-2" placeholder="Nom, slug, tagline..." />
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Actif</label>
                        <select name="active" class="mt-1 w-full border rounded-md p-2">
                            <option value="">Tous</option>
                            <option value="1" @selected(($active ?? request('active')) === '1')>Oui</option>
                            <option value="0" @selected(($active ?? request('active')) === '0')>Non</option>
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
                            <th class="py-2 pr-4">Ordre</th>
                            <th class="py-2 pr-4">Nom</th>
                            <th class="py-2 pr-4">Slug</th>
                            <th class="py-2 pr-4">Prix</th>
                            <th class="py-2 pr-4">Actif</th>
                            <th class="py-2 pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($packs as $p)
                            <tr>
                                <td class="py-3 pr-4">{{ $p->sort_order ?? '—' }}</td>
                                <td class="py-3 pr-4 font-medium text-gray-900">{{ $p->name }}</td>
                                <td class="py-3 pr-4 text-gray-700">{{ $p->slug }}</td>
                                <td class="py-3 pr-4">{{ $p->price_eur }}€</td>
                                <td class="py-3 pr-4">
                                    <span class="inline-flex px-2 py-1 rounded {{ $p->is_active ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $p->is_active ? 'oui' : 'non' }}
                                    </span>
                                </td>
                                <td class="py-3 pr-4">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('admin.packs.edit', $p) }}" class="text-gray-900 hover:underline">
                                            Éditer →
                                        </a>

                                        <form method="POST" action="{{ route('admin.packs.destroy', $p) }}"
                                              onsubmit="return confirm('Supprimer ce pack ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="py-3 pr-4">
    <span class="inline-flex px-2 py-1 rounded {{ $p->is_active ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800' }}">
        {{ $p->is_active ? 'oui' : 'non' }}
    </span>

    <form method="POST" action="{{ route('admin.packs.toggle', $p) }}" class="mt-2">
        @csrf
        @method('PATCH')
        <button class="text-sm {{ $p->is_active ? 'text-gray-700 hover:underline' : 'text-gray-900 hover:underline' }}">
            {{ $p->is_active ? 'Désactiver' : 'Activer' }}
        </button>
    </form>
</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $packs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
