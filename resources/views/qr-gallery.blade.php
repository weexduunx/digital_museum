@extends('layouts.app')

@section('title', 'Galerie QR Codes')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Galerie des QR Codes</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $testCodes = ['MASK_DIOLA_001', 'PAINT_GLASS_002', 'SCULPT_UNITY_003'];
        @endphp

        @foreach($testCodes as $code)
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <h3 class="text-lg font-semibold mb-4">{{ $code }}</h3>

                <div class="mb-4">
                    <img src="{{ route('qr.generate', $code) }}" alt="QR Code {{ $code }}" class="mx-auto border border-gray-300 rounded">
                </div>

                <p class="text-sm text-gray-600 mb-4">Scannez ce QR code pour accéder à l'œuvre</p>

                <a href="{{ route('artwork.show', $code) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200">
                    Voir l'œuvre
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-12 bg-blue-50 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-blue-900 mb-4">Comment utiliser les QR Codes :</h2>
        <ol class="list-decimal list-inside space-y-2 text-blue-800">
            <li>Imprimez ou affichez les QR codes ci-dessus près des œuvres physiques</li>
            <li>Les visiteurs peuvent scanner les codes avec leur smartphone</li>
            <li>Ils seront redirigés vers la fiche complète de l'œuvre (texte, audio, vidéo)</li>
            <li>L'expérience est multilingue (français, anglais, wolof)</li>
        </ol>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('gallery') }}"
           class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors duration-200">
            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour à la galerie
        </a>
    </div>
</div>
@endsection