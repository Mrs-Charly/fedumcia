<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Historique des actions</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" class="flex flex-col md:flex-row gap-3 md:items-end">
                    <div class="flex-1">
                        <label class="text-sm text-gray-700">Recherche</label>
                        <input name="q" value="{{ $q }}" class="mt-1 w-full border rounded-md p-2" placeholder="action, subject, metadata..." />
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Action</label>
                        <select name="action" class="mt-1 w-full border rounded-md p-2">
                            <option value="">Toutes</option>
                            @foreach($actions as $a)
                                <option value="{{ $a }}" @selected($action === $a)>{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="admin" name="admin" value="1" @checked($onlyAdmin === '1')>
                        <label for="admin" class="text-sm text-gray-700">Actions admin uniquement</label>
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
                            <th class="py-2 pr-4">Date</th>
                            <th class="py-2 pr-4">Acteur</th>
                            <th class="py-2 pr-4">Action</th>
                            <th class="py-2 pr-4">Cible</th>
                            <th class="py-2 pr-4">IP</th>
                            <th class="py-2 pr-4">Détails</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($logs as $log)
                            <tr>
                                <td class="py-3 pr-4 whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3 pr-4">
                                    @if($log->actor)
                                        <div class="font-medium text-gray-900">{{ $log->actor->name }}</div>
                                        <div class="text-gray-600">{{ $log->actor->email }}</div>
                                    @else
                                        <span class="text-gray-600">Public / système</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-4 font-medium text-gray-900">{{ $log->action }}</td>
                                <td class="py-3 pr-4 text-gray-700">
                                    @if($log->subject_type)
                                        {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="py-3 pr-4 text-gray-700">{{ $log->ip ?? '—' }}</td>
                                <td class="py-3 pr-4 text-gray-700">
                                    @if($log->metadata)
                                        <pre class="text-xs whitespace-pre-wrap">{{ json_encode($log->metadata, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $logs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
