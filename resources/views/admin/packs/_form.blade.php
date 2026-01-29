<div class="space-y-4">
    <div>
        <label class="text-sm text-gray-700">Nom</label>
        <input name="name"
               value="{{ old('name', $pack?->name) }}"
               required
               class="mt-1 w-full border rounded-md p-2" />
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm text-gray-700">Slug</label>
        <input name="slug"
               value="{{ old('slug', $pack?->slug) }}"
               placeholder="auto si vide à la création"
               class="mt-1 w-full border rounded-md p-2" />
        @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        <p class="mt-1 text-xs text-gray-500">En création : si vide, il sera généré automatiquement depuis le nom.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-sm text-gray-700">Prix (€)</label>
            <input type="number"
                   name="price_eur"
                   min="0"
                   value="{{ old('price_eur', $pack?->price_eur) }}"
                   required
                   class="mt-1 w-full border rounded-md p-2" />
            @error('price_eur') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm text-gray-700">Ordre d’affichage</label>
            <input type="number"
                   name="sort_order"
                   min="0"
                   value="{{ old('sort_order', $pack?->sort_order ?? 0) }}"
                   class="mt-1 w-full border rounded-md p-2" />
            @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="text-sm text-gray-700">Tagline</label>
        <input name="tagline"
               value="{{ old('tagline', $pack?->tagline) }}"
               class="mt-1 w-full border rounded-md p-2" />
        @error('tagline') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm text-gray-700">Description courte</label>
        <textarea name="short_description"
                  rows="4"
                  class="mt-1 w-full border rounded-md p-2">{{ old('short_description', $pack?->short_description) }}</textarea>
        @error('short_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-sm text-gray-700">Posts / mois</label>
            <input type="number"
                   name="posts_per_month"
                   min="0"
                   value="{{ old('posts_per_month', $pack?->posts_per_month) }}"
                   class="mt-1 w-full border rounded-md p-2" />
            @error('posts_per_month') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm text-gray-700">Réponse avis sous (heures)</label>
            <input type="number"
                   name="review_response_hours"
                   min="0"
                   value="{{ old('review_response_hours', $pack?->review_response_hours) }}"
                   class="mt-1 w-full border rounded-md p-2" />
            @error('review_response_hours') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="text-sm text-gray-700">Actif</label>
        <select name="is_active" class="mt-1 w-full border rounded-md p-2">
            <option value="1" @selected(old('is_active', (string)($pack?->is_active ?? 1)) === '1')>Oui</option>
            <option value="0" @selected(old('is_active', (string)($pack?->is_active ?? 1)) === '0')>Non</option>
        </select>
        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="pt-2">
        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
            Enregistrer
        </button>
    </div>
</div>
