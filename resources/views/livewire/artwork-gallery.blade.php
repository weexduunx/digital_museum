<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-16 text-center">
        <h1 class="text-5xl lg:text-6xl font-light text-gray-900 mb-6 tracking-tight">
            Galerie des Œuvres
        </h1>
        <p class="text-xl text-gray-600 font-light max-w-2xl mx-auto leading-relaxed">
            Découvrez notre collection exceptionnelle d'œuvres d'art
        </p>
        <div class="w-24 h-px bg-gray-300 mx-auto mt-8"></div>
    </div>

    <div class="bg-white/50 backdrop-blur-sm border border-gray-100 p-8 mb-12 transition-all duration-300 hover:shadow-lg">
        <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center">
            <div class="flex-1">
                <label for="search" class="sr-only">Rechercher</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="search"
                        wire:model.live.debounce.300ms="search"
                        class="block w-full pl-12 pr-4 py-3 border-0 border-b-2 border-gray-200 bg-transparent focus:ring-0 focus:border-gray-900 transition-colors duration-300 text-lg font-light"
                        placeholder="Rechercher par titre, artiste..."
                    >
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <div>
                    <label for="category" class="sr-only">Catégorie</label>
                    <select
                        id="category"
                        wire:model.live="selectedCategory"
                        class="block w-full px-4 py-3 border-0 border-b-2 border-gray-200 bg-transparent focus:ring-0 focus:border-gray-900 transition-colors duration-300 text-sm font-light"
                    >
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }} ({{ $category->artworks_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            wire:model.live="showFeaturedOnly"
                            class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50"
                        >
                        <span class="ml-3 text-sm text-gray-700 font-light tracking-wide">Coups de cœur uniquement</span>
                    </label>
                </div>

                <button
                    wire:click="resetFilters"
                    class="px-6 py-3 text-sm font-light tracking-wide text-gray-700 border-b-2 border-gray-200 hover:border-gray-900 focus:outline-none focus:border-gray-900 transition-colors duration-300 bg-transparent"
                >
                    RÉINITIALISER
                </button>
            </div>
        </div>
    </div>

    <!-- Masonry Grid Layout -->
    <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6 mb-12">
        @forelse($artworks as $artwork)
            <div class="break-inside-avoid">
                <livewire:artwork-card :artwork="$artwork" :key="$artwork->id" />
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.077-2.33"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune œuvre trouvée</h3>
                <p class="mt-2 text-gray-500">Essayez de modifier vos critères de recherche.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $artworks->links() }}
    </div>
</div>
