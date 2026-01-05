@extends('layouts.public', ['title' => 'Fedumcia — ' . $pack->name])

@section('content')
<section class="py-14">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg border p-6">
            <div class="text-sm text-gray-600">{{ $pack->tagline }}</div>
            <h1 class="mt-2 text-3xl font-extrabold text-gray-900">{{ $pack->name }}</h1>
            <div class="mt-4 text-3xl font-extrabold text-gray-900">{{ $pack->price_eur }}€</div>

            @if($pack->short_description)
                <p class="mt-4 text-gray-700">{{ $pack->short_description }}</p>
            @endif

            <div class="mt-6 text-sm text-gray-600">
                @if($pack->posts_per_month) {{ $pack->posts_per_month }} posts/mois @endif
                @if($pack->review_response_hours) • réponse avis sous {{ $pack->review_response_hours }}h @endif
            </div>
        </div>

        @if($pack->details)
            <div class="mt-6 bg-white rounded-lg border p-6">
                <h2 class="text-lg font-bold text-gray-900">Détails</h2>
                <pre class="mt-4 whitespace-pre-wrap font-sans text-gray-800">{{ $pack->details }}</pre>
            </div>
        @endif

        <div class="mt-6 bg-white rounded-lg border p-6">
            <h2 class="text-lg font-bold text-gray-900">Prochaine étape</h2>
            <p class="mt-2 text-gray-700">Prenez rendez-vous pour valider le pack le plus adapté à votre activité.</p>
            <a href="{{ route('home') }}#rdv" class="mt-4 inline-flex items-center px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                Prendre rendez-vous
            </a>
        </div>

        <div class="mt-6">
            <a href="{{ route('packs.index') }}" class="text-sm text-gray-700 hover:text-gray-900">← Retour aux packs</a>
        </div>
    </div>
</section>
@endsection
