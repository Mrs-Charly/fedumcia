@extends('layouts.public', ['title' => 'Fedumcia — Rendez-vous confirmé'])

@section('content')
<section class="py-14">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg p-6 text-center space-y-4">

            <h1 class="text-2xl font-bold text-gray-900">
                Rendez-vous enregistré
            </h1>

            <div class="bg-gray-50 border rounded-lg p-4 text-sm text-gray-800">
                {{ session('status') ?? 'Votre rendez-vous est bien enregistré.' }}
            </div>

            <a href="{{ route('home') }}"
               class="inline-block px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                Retour à l’accueil
            </a>
        </div>
    </div>
</section>
@endsection
