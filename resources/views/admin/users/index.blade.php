<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Utilisateurs</h2>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                + Nouvel utilisateur
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
                        <input name="q" value="{{ $q }}" class="mt-1 w-full border rounded-md p-2" placeholder="Nom ou email..." />
                    </div>
                    <div>
                        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">Filtrer</button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-600 border-b">
                        <tr>
                            <th class="py-2 pr-4">Nom</th>
                            <th class="py-2 pr-4">Email</th>
                            <th class="py-2 pr-4">Rôle</th>
                            <th class="py-2 pr-4">Pack</th>
                            <th class="py-2 pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($users as $u)
                            <tr>
                                <td class="py-3 pr-4 font-medium text-gray-900">{{ $u->name }}</td>
                                <td class="py-3 pr-4 text-gray-700">{{ $u->email }}</td>
                                <td class="py-3 pr-4">
                                    <span class="inline-flex px-2 py-1 rounded bg-gray-100 text-gray-800">
                                        {{ $u->is_admin ? 'admin' : 'utilisateur' }}
                                    </span>
                                </td>
                                <td class="py-3 pr-4">{{ $u->pack?->name ?? 'Aucun' }}</td>
                                <td class="py-3 pr-4 space-x-3">
                                    <a href="{{ route('admin.users.show', $u) }}" class="text-gray-900 hover:underline">
                                        Voir
                                    </a>
                                    <a href="{{ route('admin.users.edit', $u) }}" class="text-gray-900 hover:underline">
                                        Éditer
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
