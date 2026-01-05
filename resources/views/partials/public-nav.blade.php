<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>

                {{-- Liens publics --}}
                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ route('about') }}" class="text-sm text-gray-700 hover:text-gray-900">À propos</a>
                    <a href="{{ route('packs.index') }}" class="text-sm text-gray-700 hover:text-gray-900">Packs</a>
                    <a href="{{ route('appointments.thanks') }}" class="text-sm text-gray-700 hover:text-gray-900">Rendez-vous</a>
                </div>
            </div>

            {{-- Zone droite --}}
            <div class="flex items-center gap-3">
                @auth
                    @php
                        $user = auth()->user();
                        $dest = $user->is_admin ? route('admin.dashboard') : route('account.dashboard');
                    @endphp

                    <a href="{{ $dest }}" class="text-sm text-gray-700 hover:text-gray-900">
                        Accéder à mon espace
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-md bg-gray-900 text-white text-sm hover:bg-gray-800">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="px-3 py-2 rounded-md bg-gray-900 text-white text-sm hover:bg-gray-800">
                        Créer un compte
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
