@extends('layouts.app')

@section('title', 'Galerie')
@section('description', 'Explorez notre collection d\'œuvres d\'art avec une expérience interactive et multilingue.')

@section('content')
<!-- Hero Section with Museum Image -->
<div class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/hero-museum.jpg') }}"
            alt="Musée des Civilisations Noires"
            class="w-full h-full object-cover object-center"
        >
        <!-- Overlay for better text readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 py-24 sm:py-32">
        <div class="max-w-4xl">
            <!-- Museum Badge -->
            <div class="inline-flex items-center px-6 py-3 bg-white/10 backdrop-blur-sm text-white text-sm font-light mb-8 border border-white/20 tracking-wider">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                MUSÉE DES CIVILISATIONS NOIRES
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-light text-white mb-8 leading-tight tracking-tight">
                {{ __('app.discover_collection') }}
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-12 max-w-3xl leading-relaxed font-light">
                {{ __('app.immersive_experience') }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#gallery" class="inline-flex items-center px-10 py-4 bg-white text-black font-light tracking-wide hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    {{ __('app.explore_gallery') }}
                    <svg class="ml-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>

                <div x-data="{ showQrScanner: false }" class="inline-block">
                    <button @click="showQrScanner = true" class="inline-flex items-center px-10 py-4 border-2 border-white/30 text-white font-light tracking-wide backdrop-blur-sm bg-white/10 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <svg class="mr-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        {{ __('app.scan_qr_code') }}
                    </button>

                    <div x-show="showQrScanner" x-transition @click.away="showQrScanner = false" @close-scanner.window="showQrScanner = false">
                        <livewire:qr-code-scanner />
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mt-20 grid grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-light text-white mb-3 tracking-tight">3</div>
                    <div class="text-gray-300 text-sm font-light uppercase tracking-widest">ŒUVRES</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-light text-white mb-3 tracking-tight">3</div>
                    <div class="text-gray-300 text-sm font-light uppercase tracking-widest">LANGUES</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-light text-white mb-3 tracking-tight">∞</div>
                    <div class="text-gray-300 text-sm font-light uppercase tracking-widest">DÉCOUVERTES</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <a href="#gallery" class="text-white/70 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </a>
    </div>
</div>

<!-- Drapeau du Sénégal stylisé -->
<div class="relative">
    <div class="h-8 flex">
        <!-- Bande verte -->
        <div class="flex-1 bg-green-600 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-green-500"></div>
        </div>

        <!-- Bande jaune avec étoile -->
        <div class="flex-1 bg-yellow-400 relative overflow-hidden flex items-center justify-center">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-yellow-300"></div>
            <!-- Étoile verte -->
            <svg class="w-5 h-5 text-green-600 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        </div>

        <!-- Bande rouge -->
        <div class="flex-1 bg-red-600 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-500"></div>
        </div>
    </div>

    <!-- Effet de brillance subtil -->
    <div class="absolute inset-0 bg-gradient-to-b from-white/10 to-transparent pointer-events-none"></div>
</div>

<div id="gallery" class="py-20 bg-gradient-to-b from-gray-50/50 to-white">
    <livewire:artwork-gallery />
</div>

<div class="bg-gradient-to-br from-gray-50 via-white to-gray-100 py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-light text-gray-900 mb-6 tracking-tight">Fonctionnalités</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto font-light leading-relaxed">
                Découvrez notre approche innovante pour rendre l'art accessible à tous
            </p>
            <div class="w-24 h-px bg-gray-300 mx-auto mt-8"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16">
            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-900 to-gray-700 rounded-full flex items-center justify-center mx-auto mb-6 transition-transform duration-300 group-hover:scale-110 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-light text-gray-900 mb-4 tracking-wide">Scan QR Code</h3>
                <p class="text-gray-600 leading-relaxed font-light">
                    Scannez simplement le QR code près de chaque œuvre pour accéder instantanément à sa fiche descriptive complète.
                </p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-900 to-gray-700 rounded-full flex items-center justify-center mx-auto mb-6 transition-transform duration-300 group-hover:scale-110 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-light text-gray-900 mb-4 tracking-wide">Multilingue</h3>
                <p class="text-gray-600 leading-relaxed font-light">
                    Profitez des descriptions en français, anglais et wolof pour une expérience accessible à tous les visiteurs.
                </p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-900 to-gray-700 rounded-full flex items-center justify-center mx-auto mb-6 transition-transform duration-300 group-hover:scale-110 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M8.586 17.414A2 2 0 118.586 6.586l8.828 8.828-2.828 2.828a2 2 0 01-2.828 0l-8.828-8.828z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-light text-gray-900 mb-4 tracking-wide">Audio Guide</h3>
                <p class="text-gray-600 leading-relaxed font-light">
                    Écoutez des descriptions audio détaillées pour une expérience immersive et inclusive, idéale pour tous.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection