@extends('layouts.public', ['title' => 'Fedumcia — Rendez-vous confirmé'])

@section('content')
<section class="py-14">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900">Rendez-vous confirmé</h1>

            @if($already ?? false)
                <p class="mt-3 text-gray-700">Ce rendez-vous était déjà confirmé.</p>
            @else
                <p class="mt-3 text-gray-700">
                    Votre rendez-vous est confirmé.
                    Si vous n’aviez pas encore de compte, un email vous a été envoyé pour définir votre mot de passe.
                </p>
            @endif

            <div class="mt-6">
                <a href="{{ route('home') }}" class="text-sm text-gray-700 hover:text-gray-900">← Retour à l’accueil</a>
            </div>
        </div>
    </div>
</section>
@endsection
