<div class="group bg-white overflow-hidden transition-all duration-500 ease-out hover:shadow-2xl mb-6 cursor-pointer">
    <a href="{{ route('artwork.show', $artwork->qr_code) }}" class="block">
        <div class="relative overflow-hidden">
            @if($artwork->image_path)
                <div class="w-full overflow-hidden">
                    <img
                        src="{{ asset('storage/' . $artwork->image_path) }}"
                        alt="{{ $artwork->title }}"
                        class="w-full h-auto object-cover transition-transform duration-700 group-hover:scale-105"
                    >
                </div>
            @else
                <div class="aspect-[4/5] bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            <!-- Badge Nouveau style minimaliste -->
            @if($artwork->is_featured)
                <div class="absolute top-4 left-4">
                    <span class="inline-block px-3 py-1 text-xs font-medium tracking-wide text-white bg-black/80 backdrop-blur-sm">
                        COUP DE CŒUR
                    </span>
                </div>
            @endif

            <!-- Bouton QR Code (visible au hover) -->
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                <button
                    onclick="event.preventDefault(); event.stopPropagation(); openQRDrawer({
                        title: '{{ addslashes($artwork->title) }}',
                        artist: '{{ addslashes($artwork->artist) }}',
                        year: '{{ $artwork->creation_year }}',
                        category: '{{ $artwork->category->name }}',
                        image: '{{ $artwork->image_path ? asset('storage/' . $artwork->image_path) : '' }}',
                        qrCode: '{{ $artwork->qr_code }}',
                        detailUrl: '{{ route('artwork.show', $artwork->qr_code) }}'
                    })"
                    class="p-3 bg-white/95 backdrop-blur-sm hover:bg-white transition-colors duration-200 shadow-lg hover:shadow-xl"
                    title="Afficher le QR Code"
                >
                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </button>
            </div>

            <!-- Overlay avec nom d'artiste au hover -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end pointer-events-none">
                <div class="p-6 w-full">
                    <h3 class="text-white text-2xl font-light mb-1 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                        {{ $artwork->artist }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Informations de l'œuvre avec style minimaliste -->
        <div class="p-6 space-y-3 hover:bg-gray-50 transition-colors duration-200">
            <!-- Titre -->
            <div class="space-y-2">
                <h3 class="text-xl font-light text-gray-900 leading-tight group-hover:text-black transition-colors duration-300">
                    {{ $artwork->title }}
                </h3>
            </div>

            <!-- Informations complémentaires -->
            <div class="flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center space-x-3">
                    @if($artwork->creation_year)
                        <span class="font-light">{{ $artwork->creation_year }}</span>
                    @endif
                </div>

                @if($artwork->audio_path)
                    <div class="flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M8.586 17.414A2 2 0 118.586 6.586l8.828 8.828-2.828 2.828a2 2 0 01-2.828 0l-8.828-8.828z"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>
    </a>
</div>
