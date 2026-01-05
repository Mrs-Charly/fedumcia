<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rendez-vous #{{ $appointment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <div class="text-gray-600">Entreprise</div>
                        <div class="font-semibold text-gray-900">{{ $appointment->company_name }}</div>
                    </div>

                    <div>
                        <div class="text-gray-600">Date</div>
                        <div class="font-semibold text-gray-900">{{ $appointment->scheduled_at?->format('d/m/Y H:i') }}</div>
                    </div>

                    <div>
                        <div class="text-gray-600">Contact</div>
                        <div class="font-semibold text-gray-900">{{ $appointment->first_name }} {{ $appointment->last_name }}</div>
                        <div class="text-gray-600">{{ $appointment->email }}</div>
                        <div class="text-gray-600">{{ $appointment->phone }}</div>
                    </div>

                    <div class="mt-4">
                        <div class="text-sm text-gray-600">Pack souhaité</div>
                        <div class="font-semibold">
                            {{ $appointment->desiredPack?->name ?? 'Non précisé' }}
                        </div>
                    </div>


                    <div>
                        <div class="text-gray-600">Statut</div>
                        <div class="font-semibold text-gray-900">{{ $appointment->status }}</div>
                        @if($appointment->confirmed_at)
                            <div class="text-gray-600">Confirmé le {{ $appointment->confirmed_at->format('d/m/Y H:i') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">RGPD (preuve de consentement)</h3>
                <div class="mt-4 text-sm text-gray-700 space-y-1">
                    <div>Consentement : {{ $appointment->consent ? 'oui' : 'non' }}</div>
                    <div>Consentement le : {{ $appointment->consent_at?->format('d/m/Y H:i') ?? '—' }}</div>
                    <div>IP : {{ $appointment->consent_ip ?? '—' }}</div>
                    <div>User-Agent : {{ $appointment->consent_user_agent ?? '—' }}</div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Actions</h3>

                @if($appointment->status !== 'cancelled')
                    <form method="POST" action="{{ route('admin.appointments.cancel', $appointment) }}" onsubmit="return confirm('Annuler ce rendez-vous ?')">
                        @csrf
                        <button class="mt-4 px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">
                            Annuler le rendez-vous
                        </button>
                    </form>
                @else
                    <p class="mt-4 text-sm text-gray-600">Ce rendez-vous est déjà annulé.</p>
                @endif
            </div>

            <div>
                <a href="{{ route('admin.appointments.index') }}" class="text-sm text-gray-700 hover:text-gray-900">← Retour à la liste</a>
            </div>

        </div>
    </div>
</x-app-layout>
