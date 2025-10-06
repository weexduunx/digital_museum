@extends('admin.layout')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                <div>
                    <h1 class="text-3xl font-light text-gray-900 tracking-tight">{{ $category->name }}</h1>
                    @if($category->description)
                        <p class="mt-2 text-gray-600 font-light">{{ $category->description }}</p>
                    @endif
                </div>
            </div>
        </div>
        <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Éditer
        </a>
    </div>
</div>

<!-- Informations de la catégorie -->
<div class="bg-white shadow-sm border border-gray-200 p-6 mb-8">
    <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Informations</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <dt class="text-sm font-light text-gray-500 tracking-wide">NOM</dt>
            <dd class="text-sm text-gray-900 font-light">{{ $category->name }}</dd>
        </div>

        <div>
            <dt class="text-sm font-light text-gray-500 tracking-wide">COULEUR</dt>
            <dd class="flex items-center">
                <div class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $category->color }}"></div>
                <span class="text-sm text-gray-900 font-mono">{{ $category->color }}</span>
            </dd>
        </div>

        <div>
            <dt class="text-sm font-light text-gray-500 tracking-wide">NOMBRE D'ŒUVRES</dt>
            <dd class="text-sm text-gray-900 font-light">{{ $category->artworks->count() }}</dd>
        </div>
    </div>

    @if($category->description)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <dt class="text-sm font-light text-gray-500 tracking-wide mb-2">DESCRIPTION</dt>
            <dd class="text-sm text-gray-900 font-light leading-relaxed">{{ $category->description }}</dd>
        </div>
    @endif
</div>

<!-- Œuvres de cette catégorie -->
<div class="bg-white shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-light text-gray-900 tracking-wide">
                Œuvres de cette catégorie ({{ $category->artworks->count() }})
            </h2>
            <a href="{{ route('admin.artworks.create') }}?category={{ $category->id }}" class="text-sm text-gray-600 hover:text-gray-900 font-light tracking-wide transition-colors duration-200">
                Ajouter une œuvre →
            </a>
        </div>
    </div>

    @if($category->artworks->count() > 0)
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($category->artworks as $artwork)
                    <div class="border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
                        <div class="aspect-square overflow-hidden">
                            @if($artwork->image_path)
                                <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-light text-gray-900 truncate">{{ $artwork->title }}</h3>
                                <div class="flex items-center space-x-1">
                                    @if($artwork->is_featured)
                                        <span class="text-yellow-500 text-xs">⭐</span>
                                    @endif
                                    @if(!$artwork->is_active)
                                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                    @else
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    @endif
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 font-light mb-3">{{ $artwork->artist }}</p>

                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.artworks.show', $artwork) }}" class="text-xs text-gray-600 hover:text-gray-900 font-light tracking-wide transition-colors duration-200">
                                    Voir
                                </a>
                                <a href="{{ route('admin.artworks.edit', $artwork) }}" class="text-xs text-gray-600 hover:text-gray-900 font-light tracking-wide transition-colors duration-200">
                                    Éditer
                                </a>
                                <a href="{{ route('artwork.show', $artwork->qr_code) }}" target="_blank" class="text-xs text-gray-600 hover:text-gray-900 font-light tracking-wide transition-colors duration-200">
                                    Site
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-light text-gray-900">Aucune œuvre dans cette catégorie</h3>
            <p class="mt-1 text-sm text-gray-500 font-light">Ajoutez votre première œuvre à cette catégorie.</p>
            <div class="mt-6">
                <a href="{{ route('admin.artworks.create') }}?category={{ $category->id }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter une œuvre
                </a>
            </div>
        </div>
    @endif
</div>
@endsection