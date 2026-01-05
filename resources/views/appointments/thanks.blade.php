@extends('layouts.public', ['title' => 'Fedumcia — Demande envoyée'])

@section('content')
<section class="py-14">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900">Demande envoyée</h1>
            <p class="mt-3 text-gray-700">
                Merci. Un email de confirmation vient de vous être envoyé.
                Cliquez sur le lien pour confirmer le rendez-vous.
            </p>
        </div>
    </div>
</section>
@endsection
