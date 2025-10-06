@extends('admin.layout')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.artworks.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-light text-gray-900 tracking-tight">{{ $artwork->title }}</h1>
                <p class="mt-2 text-gray-600 font-light">{{ $artwork->artist }} @if($artwork->creation_year) - {{ $artwork->creation_year }} @endif</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('artwork.show', $artwork->qr_code) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-light tracking-wide hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Voir sur le site
            </a>
            <a href="{{ route('admin.artworks.edit', $artwork) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Éditer
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Colonne principale -->
    <div class="space-y-6">
        <!-- Image principale -->
        <div class="bg-white shadow-sm border border-gray-200 overflow-hidden">
            @if($artwork->image_path)
                <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 bg-gray-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Vidéo -->
        @if($artwork->video_path)
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-4">Vidéo explicative</h2>
                <video controls class="w-full">
                    <source src="{{ asset('storage/' . $artwork->video_path) }}" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture vidéo.
                </video>
            </div>
        @endif
    </div>

    <!-- Informations détaillées -->
    <div class="space-y-6">
        <!-- Informations principales -->
        <div class="bg-white shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide">Informations</h2>
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
            </div>

            <div class="space-y-4">
                <div class="flex items-center">
                    <span class="w-2 h-2 rounded-full mr-3" style="background-color: {{ $artwork->category->color }}"></span>
                    <span class="text-sm font-light text-gray-900 tracking-wide">{{ $artwork->category->name }}</span>
                </div>

                @if($artwork->medium)
                    <div>
                        <dt class="text-sm font-light text-gray-500 tracking-wide">TECHNIQUE</dt>
                        <dd class="text-sm text-gray-900 font-light">{{ $artwork->medium }}</dd>
                    </div>
                @endif

                @if($artwork->dimensions)
                    <div>
                        <dt class="text-sm font-light text-gray-500 tracking-wide">DIMENSIONS</dt>
                        <dd class="text-sm text-gray-900 font-light">{{ $artwork->dimensions }}</dd>
                    </div>
                @endif

                <div>
                    <dt class="text-sm font-light text-gray-500 tracking-wide">CODE QR</dt>
                    <dd class="text-sm text-gray-900 font-mono">{{ $artwork->qr_code }}</dd>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <a href="{{ route('qr.generate', $artwork->qr_code) }}" target="_blank" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 font-light tracking-wide transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        Voir le QR Code
                    </a>
                </div>
            </div>
        </div>

        <!-- Descriptions -->
        <div class="bg-white shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Descriptions</h2>

            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-light text-gray-500 tracking-wide mb-2">FRANÇAIS</h3>
                    <p class="text-sm text-gray-900 font-light leading-relaxed">{{ $artwork->description_fr ?: 'Aucune description' }}</p>
                </div>

                @if($artwork->description_en)
                    <div>
                        <h3 class="text-sm font-light text-gray-500 tracking-wide mb-2">ANGLAIS</h3>
                        <p class="text-sm text-gray-900 font-light leading-relaxed">{{ $artwork->description_en }}</p>
                    </div>
                @endif

                @if($artwork->description_wo)
                    <div>
                        <h3 class="text-sm font-light text-gray-500 tracking-wide mb-2">WOLOF</h3>
                        <p class="text-sm text-gray-900 font-light leading-relaxed">{{ $artwork->description_wo }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Fichiers audio -->
        @if($artwork->audio_path_fr || $artwork->audio_path_en || $artwork->audio_path_wo)
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Fichiers audio</h2>

                <div class="space-y-4">
                    @if($artwork->audio_path_fr)
                        <div>
                            <h3 class="text-sm font-light text-gray-500 tracking-wide mb-2">FRANÇAIS</h3>
                            <audio controls class="w-full">
                                <source src="{{ asset('storage/' . $artwork->audio_path_fr) }}" type="audio/mpeg">
                                Votre navigateur ne supporte pas la lecture audio.
                            </audio>
                        </div>
                    @endif

                    @if($artwork->audio_path_en)
                        <div>
                            <h3 class="text-sm font-light text-gray-500 tracking-wide mb-2">ANGLAIS</h3>
                            <audio controls class="w-full">
                                <source src="{{ asset('storage/' . $artwork->audio_path_en) }}" type="audio/mpeg">
                                Votre navigateur ne supporte pas la lecture audio.
                            </audio>
                        </div>
                    @endif

                    @if($artwork->audio_path_wo)
                        <div>
                            <h3 class="text-sm font-light text-gray-500 tracking-wide mb-2">WOLOF</h3>
                            <audio controls class="w-full">
                                <source src="{{ asset('storage/' . $artwork->audio_path_wo) }}" type="audio/mpeg">
                                Votre navigateur ne supporte pas la lecture audio.
                            </audio>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Contexte historique -->
        @if($artwork->historical_context && count($artwork->historical_context) > 0)
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Contexte historique</h2>
                <div class="space-y-3">
                    @foreach($artwork->historical_context as $context)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3"></div>
                            <p class="text-sm text-gray-700 font-light">{{ $context }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Signification culturelle -->
        @if($artwork->cultural_significance && count($artwork->cultural_significance) > 0)
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Signification culturelle</h2>
                <div class="space-y-3">
                    @foreach($artwork->cultural_significance as $significance)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3"></div>
                            <p class="text-sm text-gray-700 font-light">{{ $significance }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection