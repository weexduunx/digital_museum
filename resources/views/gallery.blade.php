@extends('layouts.app')

@section('title', 'Galerie')
@section('description', 'Explorez notre collection d\'œuvres d\'art avec une expérience interactive et multilingue.')

@section('content')
<div class="relative">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 opacity-90"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 sm:py-32">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                {{ __('app.discover_collection') }}
            </h1>
            <p class="text-xl md:text-2xl text-indigo-100 mb-8 max-w-3xl mx-auto">
                {{ __('app.immersive_experience') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#gallery" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 transition-colors duration-200">
                    {{ __('app.explore_gallery') }}
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
                <div x-data="{ showQrScanner: false }" class="inline-block">
                    <button @click="showQrScanner = true" class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-indigo-600 transition-colors duration-200">
                        <svg class="mr-2 -ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        {{ __('app.scan_qr_code') }}
                    </button>

                    <div x-show="showQrScanner" x-transition @click.away="showQrScanner = false" @close-scanner.window="showQrScanner = false">
                        <livewire:qr-code-scanner />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="gallery" class="py-16">
    <livewire:artwork-gallery />
</div>

<div class="bg-indigo-50 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Fonctionnalités</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Découvrez notre approche innovante pour rendre l'art accessible à tous
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Scan QR Code</h3>
                <p class="text-gray-600">
                    Scannez simplement le QR code près de chaque œuvre pour accéder instantanément à sa fiche descriptive complète.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Multilingue</h3>
                <p class="text-gray-600">
                    Profitez des descriptions en français, anglais et wolof pour une expérience accessible à tous les visiteurs.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M8.586 17.414A2 2 0 118.586 6.586l8.828 8.828-2.828 2.828a2 2 0 01-2.828 0l-8.828-8.828z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Audio Guide</h3>
                <p class="text-gray-600">
                    Écoutez des descriptions audio détaillées pour une expérience immersive et inclusive, idéale pour tous.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection