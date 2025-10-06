<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="relative">
        @if($artwork->image_path)
            <img
                src="{{ asset('storage/' . $artwork->image_path) }}"
                alt="{{ $artwork->title }}"
                class="w-full h-48 object-cover"
            >
        @else
            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        @if($artwork->is_featured)
            <div class="absolute top-3 left-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Coup de cœur
                </span>
            </div>
        @endif

        <div class="absolute top-3 right-3">
            <div class="w-8 h-8 rounded-full shadow-lg flex items-center justify-center" style="background-color: {{ $artwork->category->color }}">
                <span class="text-xs font-bold text-white">{{ substr($artwork->category->name, 0, 1) }}</span>
            </div>
        </div>
    </div>

    <div class="p-4">
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $artwork->title }}</h3>
        </div>

        <p class="text-sm text-gray-600 mb-2">Par {{ $artwork->artist }}</p>

        @if($artwork->creation_year)
            <p class="text-xs text-gray-500 mb-3">{{ $artwork->creation_year }}</p>
        @endif

        <p class="text-sm text-gray-700 mb-4 line-clamp-2">{{ Str::limit($artwork->description, 100) }}</p>

        <div class="flex items-center justify-between">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: {{ $artwork->category->color }}">
                {{ $artwork->category->name }}
            </span>

            <div class="flex items-center space-x-2">
                <a
                    href="{{ route('artwork.show', $artwork->qr_code) }}"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                >
                    {{ __('app.discover') }}
                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a
                    href="{{ route('qr.generate', $artwork->qr_code) }}"
                    target="_blank"
                    class="inline-flex items-center p-1.5 border border-gray-300 rounded-md text-gray-600 hover:text-indigo-600 hover:border-indigo-300 transition-colors duration-200"
                    title="Voir le QR Code"
                >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </a>
            </div>
        </div>

        @if($artwork->audio_path)
            <div class="mt-3 pt-3 border-t border-gray-100">
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M8.586 17.414A2 2 0 118.586 6.586l8.828 8.828-2.828 2.828a2 2 0 01-2.828 0l-8.828-8.828z"/>
                    </svg>
                    {{ __('app.with_audio_guide') }}
                </div>
            </div>
        @endif
    </div>
</div>
