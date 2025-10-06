@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-light text-gray-900 tracking-tight">Tableau de bord</h1>
    <p class="mt-2 text-gray-600 font-light">Aperçu de votre musée numérique</p>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-light text-gray-600 tracking-wide">TOTAL ŒUVRES</p>
                <p class="text-2xl font-light text-gray-900">{{ $stats['total_artworks'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-light text-gray-600 tracking-wide">ŒUVRES ACTIVES</p>
                <p class="text-2xl font-light text-gray-900">{{ $stats['active_artworks'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-light text-gray-600 tracking-wide">COUPS DE CŒUR</p>
                <p class="text-2xl font-light text-gray-900">{{ $stats['featured_artworks'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-light text-gray-600 tracking-wide">CATÉGORIES</p>
                <p class="text-2xl font-light text-gray-900">{{ $stats['total_categories'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2">
        <div class="bg-white shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-light text-gray-900 tracking-wide">Œuvres récentes</h2>
                    <a href="{{ route('admin.artworks.index') }}" class="text-sm font-light text-gray-600 hover:text-gray-900 tracking-wide transition-colors duration-200">
                        Voir tout →
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recent_artworks->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_artworks as $artwork)
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden">
                                    @if($artwork->image_path)
                                        <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-light text-gray-900 truncate">{{ $artwork->title }}</p>
                                    <p class="text-sm text-gray-500 font-light">{{ $artwork->artist }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="inline-block w-2 h-2 rounded-full" style="background-color: {{ $artwork->category->color }}"></span>
                                        <span class="text-xs text-gray-500 font-light">{{ $artwork->category->name }}</span>
                                        @if($artwork->is_featured)
                                            <span class="text-xs text-yellow-600">★</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('admin.artworks.edit', $artwork) }}" class="text-sm text-gray-600 hover:text-gray-900 font-light tracking-wide transition-colors duration-200">
                                        Éditer
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-light text-gray-900">Aucune œuvre</h3>
                        <p class="mt-1 text-sm text-gray-500 font-light">Commencez par créer votre première œuvre.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.artworks.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
                                Créer une œuvre
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-light text-gray-900 tracking-wide mb-4">Actions rapides</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.artworks.create') }}" class="block w-full px-4 py-2 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200 text-center">
                    Nouvelle œuvre
                </a>
                <a href="{{ route('admin.categories.create') }}" class="block w-full px-4 py-2 border border-gray-300 text-gray-700 text-sm font-light tracking-wide hover:bg-gray-50 transition-colors duration-200 text-center">
                    Nouvelle catégorie
                </a>
                <a href="{{ route('qr.gallery') }}" class="block w-full px-4 py-2 border border-gray-300 text-gray-700 text-sm font-light tracking-wide hover:bg-gray-50 transition-colors duration-200 text-center">
                    Voir les QR codes
                </a>
            </div>
        </div>
    </div>
</div>
@endsection