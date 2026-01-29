<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Éditer utilisateur — {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-sm text-gray-700">Nom</label>
                        <input name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full border rounded-md p-2" />
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 w-full border rounded-md p-2" />
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
    <label class="text-sm text-gray-700">Adresse</label>
    <input name="address_line1" value="{{ old('address_line1', $user->address_line1 ?? '') }}"
           class="mt-1 w-full border rounded-md p-2" />
    @error('address_line1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="text-sm text-gray-700">Code postal</label>
    <input name="address_postal_code" value="{{ old('address_postal_code', $user->address_postal_code ?? '') }}"
           class="mt-1 w-full border rounded-md p-2" />
    @error('address_postal_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="text-sm text-gray-700">Ville</label>
    <input name="address_city" value="{{ old('address_city', $user->address_city ?? '') }}"
           class="mt-1 w-full border rounded-md p-2" />
    @error('address_city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>


                    <div>
                        <label class="text-sm text-gray-700">Nouveau mot de passe (optionnel)</label>
                        <input type="password" name="password" class="mt-1 w-full border rounded-md p-2" />
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Pack</label>
                        <select name="pack_id" class="mt-1 w-full border rounded-md p-2">
                            <option value="">Aucun</option>
                            @foreach($packs as $pack)
                                <option value="{{ $pack->id }}" @selected(old('pack_id', $user->pack_id) == $pack->id)>{{ $pack->name }}</option>
                            @endforeach
                        </select>
                        @error('pack_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="is_admin" value="1" class="rounded border-gray-300" @checked(old('is_admin', $user->is_admin))>
                            <span>Administrateur</span>
                        </label>
                        @error('is_admin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                            Enregistrer
                        </button>

                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-700 hover:text-gray-900">Retour</a>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg text-red-700">Zone dangereuse</h3>
                <p class="mt-2 text-sm text-gray-700">Suppression définitive de l’utilisateur.</p>

                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                      onsubmit="return confirm('Supprimer cet utilisateur ?');"
                      class="mt-4">
                    @csrf
                    @method('DELETE')

                    <button class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">
                        Supprimer l’utilisateur
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
