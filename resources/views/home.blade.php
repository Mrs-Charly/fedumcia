@extends('layouts.public', ['title' => 'Fedumcia — E-réputation & image digitale'])

@section('content')
    {{-- HERO --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold text-gray-600">Vesoul & Haute-Saône (70)</p>
                <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-gray-900">
                    Attirez plus de clients et inspirez confiance en ligne.
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Fedumcia se concentre sur deux leviers mesurables : des visuels professionnels (attractivité)
                    et une e-réputation maîtrisée (confiance).
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="#rdv" class="inline-flex justify-center items-center px-5 py-3 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                        Prendre rendez-vous
                    </a>
                    <a href="{{ route('packs.index') }}" class="inline-flex justify-center items-center px-5 py-3 rounded-md border border-gray-300 bg-white hover:bg-gray-50">
                        Voir les packs
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- CONCEPT --}}
    <section class="py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900">Notre approche</h2>
            <p class="mt-2 text-gray-600 max-w-3xl">
                Pas de communication généraliste : uniquement ce qui produit un impact direct.
            </p>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg border p-6">
                    <div class="text-sm font-semibold text-gray-700">Attractivité visuelle</div>
                    <div class="mt-2 font-bold text-gray-900 text-lg">Le produit</div>
                    <ul class="mt-4 space-y-2 text-gray-700 text-sm list-disc pl-5">
                        <li>Photos & vidéos professionnelles</li>
                        <li>Contenus réseaux sociaux</li>
                        <li>Mise en valeur de l’entreprise et des produits</li>
                    </ul>
                </div>

                <div class="bg-white rounded-lg border p-6">
                    <div class="text-sm font-semibold text-gray-700">Confiance client</div>
                    <div class="mt-2 font-bold text-gray-900 text-lg">La vente</div>
                    <ul class="mt-4 space-y-2 text-gray-700 text-sm list-disc pl-5">
                        <li>Gestion e-réputation (Google / Facebook)</li>
                        <li>Réponses aux avis clients</li>
                        <li>Systèmes pour générer plus d’avis positifs</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- PACKS --}}
    <section class="py-14 bg-white" id="packs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Nos packs</h2>
                    <p class="mt-2 text-gray-600">Choisis le niveau d’accompagnement adapté à ton activité.</p>
                </div>
                <a class="text-sm font-semibold text-gray-900 hover:underline" href="{{ route('packs.index') }}">
                    Tous les packs →
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($packs as $pack)
                    <a href="{{ route('packs.show', $pack->slug) }}" class="block rounded-lg border p-6 hover:shadow-sm transition">
                        <div class="text-sm text-gray-600">{{ $pack->tagline }}</div>
                        <div class="mt-2 text-xl font-bold text-gray-900">{{ $pack->name }}</div>
                        <div class="mt-4 text-3xl font-extrabold text-gray-900">{{ $pack->price_eur }}€</div>

                        @if($pack->short_description)
                            <p class="mt-4 text-sm text-gray-700">{{ $pack->short_description }}</p>
                        @endif

                        <div class="mt-5 text-xs text-gray-600">
                            @if($pack->posts_per_month) {{ $pack->posts_per_month }} posts/mois @endif
                            @if($pack->review_response_hours) • réponse avis sous {{ $pack->review_response_hours }}h @endif
                        </div>

                        <div class="mt-6 text-sm font-semibold text-gray-900">
                            Voir le détail →
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- RDV --}}
    <section class="py-14" id="rdv">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900">Prendre rendez-vous</h2>
            <p class="mt-2 text-gray-600 max-w-3xl">
                Laisse tes informations et propose une date. Nous confirmerons par email.
            </p>

            <form method="POST" action="{{ route('appointments.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @csrf

    <div>
        <label class="text-sm text-gray-700">Nom</label>
        <input name="last_name" required class="mt-1 w-full border rounded-md p-2" />
    </div>

    <div>
        <label class="text-sm text-gray-700">Prénom</label>
        <input name="first_name" required class="mt-1 w-full border rounded-md p-2" />
    </div>

    <div>
        <label class="text-sm text-gray-700">Email</label>
        <input type="email" name="email" required class="mt-1 w-full border rounded-md p-2" />
    </div>

    <div>
        <label class="text-sm text-gray-700">Téléphone</label>
        <input name="phone" required class="mt-1 w-full border rounded-md p-2" />
    </div>

    <div class="md:col-span-2">
        <label class="text-sm text-gray-700">Nom de l’entreprise</label>
        <input name="company_name" required class="mt-1 w-full border rounded-md p-2" />
    </div>

    <div class="md:col-span-2">
    <label class="text-sm text-gray-700">Adresse (rue)</label>
    <input name="company_address"
           value="{{ old('company_address') }}"
           class="mt-1 w-full border rounded-md p-2" />
    @error('company_address')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="text-sm text-gray-700">Code postal</label>
    <input name="company_postal_code"
           value="{{ old('company_postal_code') }}"
           class="mt-1 w-full border rounded-md p-2" />
    @error('company_postal_code')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="text-sm text-gray-700">Ville</label>
    <input name="company_city"
           value="{{ old('company_city') }}"
           class="mt-1 w-full border rounded-md p-2" />
    @error('company_city')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

    <div>
    <label class="block text-sm font-medium text-gray-700">
        Pack souhaité (indicatif)
    </label>

    <select name="desired_pack_id"
            class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        <option value="">Je ne sais pas encore</option>

        @foreach($packs as $pack)
            <option value="{{ $pack->id }}">
                {{ $pack->name }} — {{ $pack->price_eur }} €
            </option>
        @endforeach
    </select>

    <p class="mt-1 text-xs text-gray-500">
        Ce choix est indicatif et sera validé ensemble lors du rendez-vous.
    </p>
</div>


    @php
    // Affichage sur 14 jours, uniquement jours ouvrés (lun→ven)
    $days = [];
    $cursor = now()->startOfDay();
    for ($i = 0; $i < 14; $i++) {
        $d = $cursor->copy()->addDays($i);
        if (!$d->isWeekend()) {
            $days[] = $d;
        }
    }

    // Créneaux: 08:00 → 17:00 (dernier créneau = 17h-18h)
    $hours = range(8, 17);

    // $taken est fourni par le HomeController (tableau de "Y-m-d H:00:00")
    $takenSet = collect($taken ?? [])->flip();
@endphp

<div class="md:col-span-2">
    <label class="text-sm font-medium text-gray-700">
        Choisir un créneau (lundi → vendredi, 8h–18h)
    </label>

    {{-- valeur envoyée au backend --}}
    <input type="hidden" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}">

    @error('scheduled_at')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror

    <div class="mt-4 overflow-x-auto border rounded-lg bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">Heure</th>
                    @foreach($days as $d)
                        <th class="p-3">
                            {{ $d->translatedFormat('D d/m') }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($hours as $h)
                    <tr class="border-t">
                        <td class="p-3 font-medium">
                            {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}:00
                        </td>

                        @foreach($days as $d)
                            @php
                                $slot = $d->copy()->setTime($h, 0);
                                $key = $slot->format('Y-m-d H:00:00');

                                $isTaken = isset($takenSet[$key]);
                                $isPast  = $slot->lt(now());
                            @endphp

                            <td class="p-2">
                                <button
                                    type="button"
                                    class="slot-btn w-full px-2 py-2 rounded-md border
                                        {{ ($isTaken || $isPast) ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'hover:bg-gray-50' }}"
                                    data-slot="{{ $slot->format('Y-m-d\TH:i') }}"
                                    {{ ($isTaken || $isPast) ? 'disabled' : '' }}
                                >
                                    {{ $isTaken ? 'Pris' : ($isPast ? 'Passé' : 'Disponible') }}
                                </button>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="mt-3 text-sm">
        Créneau sélectionné :
        <span id="slot_preview" class="font-semibold">Aucun</span>
    </p>

    <p class="mt-1 text-xs text-gray-500">
        Dernier créneau possible : 17h–18h.
    </p>
</div>


    <div class="md:col-span-2">
        <label class="inline-flex items-start gap-2 text-sm text-gray-700">
            <input type="checkbox" name="consent" required class="mt-1">
            <span>
                J’accepte que Fedumcia traite mes données pour gérer ma demande de rendez-vous.
            </span>
        </label>
    </div>

    <div class="md:col-span-2">
        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
            Envoyer la demande
        </button>
    </div>
</form>

        </div>
    </section>

    {{-- AVIS --}}
    <section class="py-14 bg-white" id="avis">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900">Avis</h2>
            @if(session('status'))
    <div class="mt-4 bg-white border rounded-lg p-4 text-sm">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('reviews.store') }}" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 bg-white border rounded-lg p-6">
    @csrf

    <div>
        <label class="text-sm text-gray-700">Nom</label>
        <input name="name" value="{{ old('name') }}" required class="mt-1 w-full border rounded-md p-2" />
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm text-gray-700">Entreprise (optionnel)</label>
        <input name="company" value="{{ old('company') }}" class="mt-1 w-full border rounded-md p-2" />
        @error('company') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm text-gray-700">Note</label>
        <select name="rating" required class="mt-1 w-full border rounded-md p-2">
            @for($i=5; $i>=1; $i--)
                <option value="{{ $i }}" @selected((int)old('rating', 5) === $i)>{{ $i }}/5</option>
            @endfor
        </select>
        @error('rating') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="text-sm text-gray-700">Votre avis</label>
        <textarea name="comment" required class="mt-1 w-full border rounded-md p-2" rows="4">{{ old('comment') }}</textarea>
        @error('comment') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <button class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
            Envoyer mon avis
        </button>
        <p class="mt-2 text-xs text-gray-500">Publication après validation par l’équipe.</p>
    </div>
</form>

<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    @forelse($reviews as $review)
        <div class="rounded-lg border p-6 bg-white">
            <div class="text-sm text-gray-600">{{ $review->rating }}/5</div>
            <p class="mt-2 text-sm text-gray-700">
                “{{ $review->comment }}”
            </p>
            <div class="mt-4 text-sm font-semibold text-gray-900">{{ $review->name }}</div>
            <div class="text-xs text-gray-600">{{ $review->company ?? 'Client' }}</div>
        </div>
    @empty
        <div class="text-sm text-gray-600">
            Aucun avis publié pour le moment.
        </div>
    @endforelse
</div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                @for($i=0; $i<3; $i++)
                    <div class="rounded-lg border p-6">
                        <p class="text-sm text-gray-700">
                            “Service réactif, image plus pro et avis mieux gérés. On recommande.”
                        </p>
                        <div class="mt-4 text-sm font-semibold text-gray-900">Client local</div>
                        <div class="text-xs text-gray-600">Vesoul</div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    {{-- PARTENAIRES --}}
    <section class="py-14" id="partenaires">
        <div class="mt-8 bg-white rounded-lg border p-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6 items-center">
        @forelse($partners as $partner)
            @php $content = $partner->logo_path
                ? '<img src="'.asset('storage/'.$partner->logo_path).'" alt="'.e($partner->name).'" class="h-10 w-auto mx-auto">'
                : '<div class="text-sm text-gray-700 text-center">'.e($partner->name).'</div>';
            @endphp

            @if($partner->website_url)
                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener" class="block hover:opacity-80">
                    {!! $content !!}
                </a>
            @else
                <div class="block">
                    {!! $content !!}
                </div>
            @endif
        @empty
            <div class="text-sm text-gray-600">
                Aucun partenaire pour le moment.
            </div>
        @endforelse
    </div>
</div>

    </section>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const hidden = document.getElementById('scheduled_at');
    const preview = document.getElementById('slot_preview');

    document.querySelectorAll('.slot-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const value = btn.dataset.slot;

            hidden.value = value;
            preview.textContent = value;

            document.querySelectorAll('.slot-btn').forEach(b => {
                b.classList.remove('ring-2', 'ring-gray-900');
            });

            btn.classList.add('ring-2', 'ring-gray-900');
        });
    });
});
</script>

@endsection
