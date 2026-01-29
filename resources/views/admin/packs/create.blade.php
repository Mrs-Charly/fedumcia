<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau pack</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.packs.store') }}">
                    @csrf
                    @include('admin.packs._form', ['pack' => null])
                </form>
            </div>

            <div>
                <a href="{{ route('admin.packs.index') }}" class="text-sm text-gray-700 hover:text-gray-900">← Retour</a>
            </div>
        </div>
    </div>
</x-app-layout>
