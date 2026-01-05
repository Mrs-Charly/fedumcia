<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rendez-vous
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" class="flex flex-col md:flex-row gap-3 md:items-end">
                    <div class="flex-1">
                        <label class="text-sm text-gray-700">Recherche</label>
                        <input name="q" value="{{ request('q') }}" class="mt-1 w-full border rounded-md p-2" placeholder="Email, entreprise, nom..." />
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Statut</label>
                        <select name="status" class="mt-1 w-full border rounded-md p-2">
                            <option value="">Tous</option>
                            <option value="pending" @selected(request('status') === 'pending')>pending</option>
                            <option value="confirmed" @selected(request('status') === 'confirmed')>confirmed</option>
                            <option value="cancelled" @selected(request('status') === 'cancelled')>cancelled</option>
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
                            <th class="py-2 pr-4">Entreprise</th>
                            <th class="py-2 pr-4">Contact</th>
                            <th class="py-2 pr-4">Statut</th>
                            <th class="py-2 pr-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($appointments as $a)
                            <tr>
                                <td class="py-3 pr-4">{{ $a->scheduled_at?->format('d/m/Y H:i') }}</td>
                                <td class="py-3 pr-4">{{ $a->company_name }}</td>
                                <td class="py-3 pr-4">
                                    {{ $a->first_name }} {{ $a->last_name }}<br>
                                    <span class="text-gray-600">{{ $a->email }}</span>
                                </td>
                                <td class="py-3 pr-4">{{ $a->status }}</td>
                                <td class="py-3 pr-4">
                                    <a href="{{ route('admin.appointments.show', $a) }}" class="text-gray-900 hover:underline">
                                        Ouvrir →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $appointments->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
