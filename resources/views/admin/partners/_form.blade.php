@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="text-sm text-gray-700">Nom</label>
        <input name="name" value="{{ old('name', $partner?->name) }}" required class="mt-1 w-full border rounded-md p-2" />
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="text-sm text-gray-700">Site web (optionnel)</label>
        <input name="website_url" value="{{ old('website_url', $partner?->website_url) }}" class="mt-1 w-full border rounded-md p-2" />
        @error('website_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm text-gray-700">Actif</label>
        <select name="is_active" class="mt-1 w-full border rounded-md p-2">
            <option value="1" @selected(old('is_active', $partner?->is_active ?? true) == true)>Oui</option>
            <option value="0" @selected(old('is_active', $partner?->is_active ?? true) == false)>Non</option>
        </select>
        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm text-gray-700">Ordre d’affichage</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $partner?->sort_order ?? 0) }}" class="mt-1 w-full border rounded-md p-2" min="0" />
        @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="text-sm text-gray-700">Logo (jpg/png/webp, max 2MB)</label>
        <input type="file" name="logo" class="mt-1 w-full border rounded-md p-2" />
        @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

        @if($partner?->logo_path)
            <div class="mt-3 flex items-center gap-4">
                <img src="{{ asset('storage/'.$partner->logo_path) }}" class="h-10 w-auto" alt="{{ $partner->name }}">
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="remove_logo" value="1">
                    Supprimer le logo
                </label>
            </div>
        @endif
    </div>
</div>

<div class="mt-6">
    <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
        Enregistrer
    </button>
</div>
