<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Éditer : {{ $pack->name }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.packs.update', $pack) }}">
                    @csrf
                    @method('PUT')
                    @include('admin.packs._form', ['pack' => $pack])
                </form>
            </div>

            <div>
                <a href="{{ route('admin.packs.index') }}" class="text-sm text-gray-700 hover:text-gray-900">← Retour</a>
            </div>

        </div>
    </div>
</x-app-layout>
