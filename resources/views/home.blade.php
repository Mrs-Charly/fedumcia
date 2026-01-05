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


    <div class="md:col-span-2">
        <label class="text-sm text-gray-700">Date souhaitée</label>
        <input type="datetime-local" name="scheduled_at" required class="mt-1 w-full border rounded-md p-2" />
        <p class="mt-1 text-xs text-gray-500">La date doit être dans le futur.</p>
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
            <p class="mt-2 text-gray-600">Exemples (à remplacer par de vrais témoignages).</p>

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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900">Partenaires</h2>
            <p class="mt-2 text-gray-600">Logos / noms à intégrer.</p>

            <div class="mt-8 bg-white rounded-lg border p-6 text-sm text-gray-700">
                Zone partenaires (à alimenter).
            </div>
        </div>
    </section>
@endsection
