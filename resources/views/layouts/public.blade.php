<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Fedumcia' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    @include('partials.public-nav')

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="border-t bg-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-sm text-gray-600">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="font-semibold text-gray-900">Fedumcia</div>
                    <div>Vesoul & Haute-Saône (70) — E-réputation & image digitale</div>
                </div>

                <div class="flex gap-4">
                    <a href="#" class="hover:text-gray-900">Mentions légales</a>
                    <a href="#" class="hover:text-gray-900">Politique de confidentialité</a>
                    <a href="#" class="hover:text-gray-900">Cookies</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
