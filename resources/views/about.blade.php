@extends('layouts.public', ['title' => 'Fedumcia — À propos'])

@section('content')
<section class="py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        {{-- INTRO --}}
        <div class="max-w-3xl">
            <h1 class="text-3xl font-extrabold text-gray-900">À propos de Fedumcia</h1>
            <p class="mt-4 text-gray-700">
                Fedumcia est une agence locale spécialisée dans l’e-réputation et l’image digitale,
                pensée pour les commerces, artisans et petites entreprises de Vesoul et du 70.
            </p>
        </div>

        {{-- ÉQUIPE --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-900">L’équipe</h2>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border rounded-lg p-6">
                    <div class="font-semibold text-gray-900">Fondateur 1</div>
                    <div class="text-sm text-gray-600 mt-1">Création visuelle & contenu</div>
                    <p class="mt-3 text-sm text-gray-700">
                        Spécialisé dans la création de visuels, photos, vidéos et identité digitale.
                    </p>
                </div>

                <div class="bg-white border rounded-lg p-6">
                    <div class="font-semibold text-gray-900">Fondateur 2</div>
                    <div class="text-sm text-gray-600 mt-1">E-réputation & stratégie</div>
                    <p class="mt-3 text-sm text-gray-700">
                        Spécialisé dans la gestion des avis, la relation client et la stratégie locale.
                    </p>
                </div>
            </div>
        </div>

        {{-- PROJETS --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Projets réalisés</h2>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border rounded-lg p-6">
                    <div class="font-semibold text-gray-900">Création de vêtements</div>
                    <ul class="mt-3 text-sm text-gray-700 list-disc pl-5 space-y-1">
                        <li>Création de visuels produits</li>
                        <li>Mise en valeur de la marque</li>
                        <li>Contenus réseaux sociaux</li>
                    </ul>
                </div>

                <div class="bg-white border rounded-lg p-6">
                    <div class="font-semibold text-gray-900">Club de handball de Vesoul</div>
                    <ul class="mt-3 text-sm text-gray-700 list-disc pl-5 space-y-1">
                        <li>Gestion des publications Instagram</li>
                        <li>Augmentation de l’engagement</li>
                        <li>Visibilité locale renforcée</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- STATISTIQUES --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Résultats observés</h2>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white border rounded-lg p-6 text-center">
                    <div class="text-3xl font-extrabold text-gray-900">+XX%</div>
                    <div class="mt-2 text-sm text-gray-600">Engagement réseaux sociaux</div>
                </div>

                <div class="bg-white border rounded-lg p-6 text-center">
                    <div class="text-3xl font-extrabold text-gray-900">★★★★★</div>
                    <div class="mt-2 text-sm text-gray-600">Notes moyennes clients</div>
                </div>

                <div class="bg-white border rounded-lg p-6 text-center">
                    <div class="text-3xl font-extrabold text-gray-900">+XX</div>
                    <div class="mt-2 text-sm text-gray-600">Avis positifs générés</div>
                </div>
            </div>

            <p class="mt-4 text-xs text-gray-500">
                Données indicatives – résultats variables selon les projets.
            </p>
        </div>

    </div>
</section>
@endsection
