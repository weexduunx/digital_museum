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
            <h1 class="text-3xl font-light text-gray-900 tracking-tight">Éditer la catégorie</h1>
            <p class="mt-2 text-gray-600 font-light">{{ $category->name }}</p>
        </div>
    </div>
</div>

<div class="max-w-2xl">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="bg-white shadow-sm border border-gray-200 p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-light text-gray-700 tracking-wide mb-2">NOM DE LA CATÉGORIE *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                       class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                @error('name')
                    <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-light text-gray-700 tracking-wide mb-2">DESCRIPTION</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="color" class="block text-sm font-light text-gray-700 tracking-wide mb-2">COULEUR *</label>
                <div class="flex items-center space-x-3">
                    <input type="color" name="color" id="color" value="{{ old('color', $category->color) }}" required
                           class="h-10 w-20 border border-gray-300 rounded">
                    <input type="text" name="color_text" id="color_text" value="{{ old('color', $category->color) }}" pattern="^#[0-9A-Fa-f]{6}$"
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
                Mettre à jour
            </button>
            <a href="{{ route('admin.categories.index') }}" class="flex-1 py-3 border border-gray-300 text-gray-700 text-sm font-light tracking-wide hover:bg-gray-50 transition-colors duration-200 text-center">
                Annuler
            </a>
        </div>

    </form>

    <!-- Zone de suppression séparée -->
    @if($category->artworks()->count() == 0)
        <div class="mt-8 bg-white shadow-sm border border-red-200 p-6">
            <h3 class="text-lg font-light text-gray-900 tracking-wide mb-4 text-center">Zone de danger</h3>
            <p class="text-sm text-gray-600 font-light mb-6 text-center">
                Cette action supprimera définitivement la catégorie.
            </p>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-3 bg-red-600 text-white text-sm font-light tracking-wide hover:bg-red-700 transition-colors duration-200">
                    Supprimer définitivement la catégorie
                </button>
            </form>
        </div>
    @else
        <div class="mt-8 bg-white shadow-sm border border-gray-200 p-6">
            <div class="text-center">
                <svg class="mx-auto h-8 w-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <p class="text-sm text-gray-500 font-light">
                    Cette catégorie contient {{ $category->artworks()->count() }} œuvre(s) et ne peut pas être supprimée.
                </p>
            </div>
        </div>
    @endif
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