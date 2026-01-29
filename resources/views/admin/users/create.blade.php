<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Créer un utilisateur</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="text-sm text-gray-700">Nom</label>
                        <input name="name" value="{{ old('name') }}" required class="mt-1 w-full border rounded-md p-2" />
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full border rounded-md p-2" />
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
                        <label class="text-sm text-gray-700">Mot de passe (min 10)</label>
                        <input type="password" name="password" required class="mt-1 w-full border rounded-md p-2" />
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-700">Pack</label>
                        <select name="pack_id" class="mt-1 w-full border rounded-md p-2">
                            <option value="">Aucun</option>
                            @foreach($packs as $pack)
                                <option value="{{ $pack->id }}" @selected(old('pack_id') == $pack->id)>{{ $pack->name }}</option>
                            @endforeach
                        </select>
                        @error('pack_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="is_admin" value="1" class="rounded border-gray-300">
                            <span>Administrateur</span>
                        </label>
                        @error('is_admin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                            Créer
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-700 hover:text-gray-900">Annuler</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
