@extends('admin.layout')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-light text-gray-900 tracking-tight">Œuvres d'art</h1>
            <p class="mt-2 text-gray-600 font-light">Gérez votre collection d'œuvres</p>
        </div>
        <a href="{{ route('admin.artworks.create') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle œuvre
        </a>
    </div>
</div>

<div class="bg-white shadow-sm border border-gray-200">
    @if($artworks->count() > 0)
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-light text-gray-500 uppercase tracking-wider">Œuvre</th>
                        <th class="px-6 py-3 text-left text-xs font-light text-gray-500 uppercase tracking-wider">Catégorie</th>
                        <th class="px-6 py-3 text-left text-xs font-light text-gray-500 uppercase tracking-wider">QR Code</th>
                        <th class="px-6 py-3 text-left text-xs font-light text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-light text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($artworks as $artwork)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden">
                                        @if($artwork->image_path)
                                            <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-light text-gray-900">{{ $artwork->title }}</div>
                                        <div class="text-sm text-gray-500 font-light">{{ $artwork->artist }}</div>
                                        @if($artwork->creation_year)
                                            <div class="text-xs text-gray-400 font-light">{{ $artwork->creation_year }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-light text-white" style="background-color: {{ $artwork->category->color }}">
                                    {{ $artwork->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm text-gray-900">{{ $artwork->qr_code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    @if($artwork->is_active)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-light bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-light bg-gray-100 text-gray-800">
                                            Inactif
                                        </span>
                                    @endif
                                    @if($artwork->is_featured)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-light bg-yellow-100 text-yellow-800">
                                            ⭐ Coup de cœur
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.artworks.show', $artwork) }}" class="text-gray-600 hover:text-gray-900 text-sm font-light tracking-wide transition-colors duration-200">
                                        Voir
                                    </a>
                                    <a href="{{ route('admin.artworks.edit', $artwork) }}" class="text-gray-600 hover:text-gray-900 text-sm font-light tracking-wide transition-colors duration-200">
                                        Éditer
                                    </a>
                                    <form action="{{ route('admin.artworks.toggle-featured', $artwork) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm font-light tracking-wide transition-colors duration-200">
                                            {{ $artwork->is_featured ? 'Retirer' : 'Mettre' }} en avant
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.artworks.toggle-active', $artwork) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-light tracking-wide transition-colors duration-200">
                                            {{ $artwork->is_active ? 'Désactiver' : 'Activer' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $artworks->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-light text-gray-900">Aucune œuvre</h3>
            <p class="mt-1 text-sm text-gray-500 font-light">Commencez par créer votre première œuvre d'art.</p>
            <div class="mt-6">
                <a href="{{ route('admin.artworks.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Créer une œuvre
                </a>
            </div>
        </div>
    @endif
</div>
@endsection