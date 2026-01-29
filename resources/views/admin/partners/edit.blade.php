<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Éditer : {{ $partner->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="bg-white border rounded-lg p-4 text-sm">{{ session('status') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.partners._form', ['partner' => $partner])
                </form>
            </div>

            <div>
                <a href="{{ route('admin.partners.index') }}" class="text-sm text-gray-700 hover:text-gray-900">← Retour</a>
            </div>

        </div>
    </div>
</x-app-layout>
