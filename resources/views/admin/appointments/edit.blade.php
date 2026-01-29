<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le rendez-vous #{{ $appointment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <form method="POST"
                  action="{{ route('admin.appointments.update', $appointment) }}"
                  class="bg-white shadow-sm rounded-lg p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm text-gray-700">Entreprise</label>
                    <input name="company_name"
                           value="{{ old('company_name', $appointment->company_name) }}"
                           class="mt-1 w-full border rounded-md p-2" />
                </div>

                <div>
                    <label class="text-sm text-gray-700">Date et heure</label>
                    <input type="datetime-local"
                           name="scheduled_at"
                           step="3600"
                           value="{{ old('scheduled_at', $appointment->scheduled_at?->format('Y-m-d\TH:00')) }}"
                           class="mt-1 w-full border rounded-md p-2" />

                    @error('scheduled_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-700">Pack souhaité</label>
                    <select name="desired_pack_id"
                            class="mt-1 w-full border rounded-md p-2">
                        <option value="">— Aucun —</option>
                        @foreach($packs as $pack)
                            <option value="{{ $pack->id }}"
                                @selected(old('desired_pack_id', $appointment->desired_pack_id) == $pack->id)>
                                {{ $pack->name }} — {{ $pack->price_eur }} €
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-700">Note interne (admin)</label>
                    <textarea name="admin_note"
                              rows="4"
                              class="mt-1 w-full border rounded-md p-2">{{ old('admin_note', $appointment->admin_note) }}</textarea>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('admin.appointments.show', $appointment) }}"
                       class="text-sm text-gray-600 hover:underline">
                        ← Annuler
                    </a>

                    <button class="px-4 py-2 bg-gray-900 text-white rounded-md hover:bg-gray-800">
                        Enregistrer
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
