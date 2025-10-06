@extends('admin.layout')

@section('content')
<div class="mb-8">
    <div class="flex items-center">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-light text-gray-900 tracking-tight">Créer une catégorie</h1>
            <p class="mt-2 text-gray-600 font-light">Ajoutez une nouvelle catégorie d'œuvres</p>
        </div>
    </div>
</div>

<div class="max-w-2xl">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white shadow-sm border border-gray-200 p-6">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-light text-gray-700 tracking-wide mb-2">NOM DE LA CATÉGORIE *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                @error('name')
                    <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-light text-gray-700 tracking-wide mb-2">DESCRIPTION</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="color" class="block text-sm font-light text-gray-700 tracking-wide mb-2">COULEUR *</label>
                <div class="flex items-center space-x-3">
                    <input type="color" name="color" id="color" value="{{ old('color', '#6B7280') }}" required
                           class="h-10 w-20 border border-gray-300 rounded">
                    <input type="text" name="color_text" id="color_text" value="{{ old('color', '#6B7280') }}" pattern="^#[0-9A-Fa-f]{6}$"
                           class="flex-1 px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light font-mono text-sm">
                </div>
                <p class="mt-1 text-xs text-gray-500 font-light">Utilisez le sélecteur de couleur ou entrez un code hexadécimal</p>
                @error('color')
                    <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 flex space-x-3">
            <button type="submit" class="flex-1 py-3 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
                Créer la catégorie
            </button>
            <a href="{{ route('admin.categories.index') }}" class="flex-1 py-3 border border-gray-300 text-gray-700 text-sm font-light tracking-wide hover:bg-gray-50 transition-colors duration-200 text-center">
                Annuler
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorPicker = document.getElementById('color');
    const colorText = document.getElementById('color_text');

    colorPicker.addEventListener('change', function() {
        colorText.value = this.value;
    });

    colorText.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            colorPicker.value = this.value;
        }
    });
});
</script>
@endsection