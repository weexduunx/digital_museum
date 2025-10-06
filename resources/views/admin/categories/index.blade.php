@extends('admin.layout')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-light text-gray-900 tracking-tight">Catégories</h1>
            <p class="mt-2 text-gray-600 font-light">Gérez les catégories d'œuvres</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle catégorie
        </a>
    </div>
</div>

<div class="bg-white shadow-sm border border-gray-200">
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($categories as $category)
                <div class="border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                            <h3 class="text-lg font-light text-gray-900 tracking-wide">{{ $category->name }}</h3>
                        </div>
                        <span class="text-sm font-light text-gray-500">{{ $category->artworks_count }} œuvre{{ $category->artworks_count !== 1 ? 's' : '' }}</span>
                    </div>

                    @if($category->description)
                        <p class="text-sm text-gray-600 font-light mb-4">{{ $category->description }}</p>
                    @endif

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.categories.show', $category) }}" class="text-gray-600 hover:text-gray-900 text-sm font-light tracking-wide transition-colors duration-200">
                            Voir
                        </a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-gray-600 hover:text-gray-900 text-sm font-light tracking-wide transition-colors duration-200">
                            Éditer
                        </a>
                        @if($category->artworks_count == 0)
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-light tracking-wide transition-colors duration-200">
                                    Supprimer
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <h3 class="mt-2 text-sm font-light text-gray-900">Aucune catégorie</h3>
            <p class="mt-1 text-sm text-gray-500 font-light">Commencez par créer votre première catégorie.</p>
            <div class="mt-6">
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Créer une catégorie
                </a>
            </div>
        </div>
    @endif
</div>
@endsection