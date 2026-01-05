@extends('layouts.public', ['title' => 'Fedumcia — Packs'])

@section('content')
<section class="py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Nos Packs</h1>
        <p class="mt-2 text-gray-600">Offres adaptées aux commerces, artisans et petites entreprises locales.</p>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($packs as $pack)
                <a href="{{ route('packs.show', $pack->slug) }}" class="block bg-white rounded-lg border p-6 hover:shadow-sm transition">
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
@endsection
