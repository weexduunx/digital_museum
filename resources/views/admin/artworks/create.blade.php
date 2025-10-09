@extends('admin.layout')

@section('content')
<div class="mb-8">
    <div class="flex items-center">
        <a href="{{ route('admin.artworks.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-light text-gray-900 tracking-tight">Créer une œuvre</h1>
            <p class="mt-2 text-gray-600 font-light">Ajoutez une nouvelle œuvre à votre collection</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.artworks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Informations principales</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-light text-gray-700 tracking-wide mb-2">TITRE *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="artist" class="block text-sm font-light text-gray-700 tracking-wide mb-2">ARTISTE *</label>
                        <input type="text" name="artist" id="artist" value="{{ old('artist') }}" required
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                        @error('artist')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-light text-gray-700 tracking-wide mb-2">CATÉGORIE *</label>
                        <select name="category_id" id="category_id" required
                                class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="creation_year" class="block text-sm font-light text-gray-700 tracking-wide mb-2">ANNÉE DE CRÉATION</label>
                        <input type="number" name="creation_year" id="creation_year" value="{{ old('creation_year') }}" min="1000" max="{{ date('Y') }}"
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                        @error('creation_year')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="medium" class="block text-sm font-light text-gray-700 tracking-wide mb-2">TECHNIQUE</label>
                        <input type="text" name="medium" id="medium" value="{{ old('medium') }}" placeholder="Huile sur toile, Bronze..."
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                        @error('medium')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="dimensions" class="block text-sm font-light text-gray-700 tracking-wide mb-2">DIMENSIONS</label>
                        <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions') }}" placeholder="120 x 80 cm"
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                        @error('dimensions')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Descriptions multilingues -->
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Descriptions</h2>

                <div class="space-y-6">
                    <div>
                        <label for="description_fr" class="block text-sm font-light text-gray-700 tracking-wide mb-2">DESCRIPTION FRANÇAISE *</label>
                        <textarea name="description_fr" id="description_fr" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">{{ old('description_fr') }}</textarea>
                        @error('description_fr')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description_en" class="block text-sm font-light text-gray-700 tracking-wide mb-2">DESCRIPTION ANGLAISE</label>
                        <textarea name="description_en" id="description_en" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description_wo" class="block text-sm font-light text-gray-700 tracking-wide mb-2">DESCRIPTION WOLOF</label>
                        <textarea name="description_wo" id="description_wo" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">{{ old('description_wo') }}</textarea>
                        @error('description_wo')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contexte et signification -->
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Contexte et signification</h2>

                <div class="space-y-6">
                    <div>
                        <label for="historical_context" class="block text-sm font-light text-gray-700 tracking-wide mb-2">CONTEXTE HISTORIQUE</label>
                        <textarea name="historical_context" id="historical_context" rows="4" placeholder="Une ligne par point de contexte"
                                  class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">{{ old('historical_context') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500 font-light">Séparez chaque point par une nouvelle ligne</p>
                        @error('historical_context')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cultural_significance" class="block text-sm font-light text-gray-700 tracking-wide mb-2">SIGNIFICATION CULTURELLE</label>
                        <textarea name="cultural_significance" id="cultural_significance" rows="4" placeholder="Une ligne par point de signification"
                                  class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">{{ old('cultural_significance') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500 font-light">Séparez chaque point par une nouvelle ligne</p>
                        @error('cultural_significance')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Fichiers et options -->
        <div class="space-y-6">
            <!-- Image -->
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-light text-gray-900 tracking-wide">Image principale</h2>
                    <button type="button" id="analyze-image-btn"
                            class="hidden px-4 py-2 bg-blue-600 text-white text-xs font-light tracking-wide hover:bg-blue-700 transition-colors duration-200 rounded">
                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Analyser avec IA
                    </button>
                </div>

                <div>
                    <label for="image" class="block text-sm font-light text-gray-700 tracking-wide mb-2">IMAGE</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                    <p class="mt-1 text-xs text-gray-500 font-light">JPG, PNG, GIF - Max 2MB</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                    @enderror

                    <!-- Prévisualisation de l'image -->
                    <div id="image-preview" class="mt-4 hidden">
                        <img src="" alt="Prévisualisation" class="w-full h-48 object-cover rounded border border-gray-200">
                    </div>

                    <!-- Message de chargement -->
                    <div id="analyzing-message" class="hidden mt-4 p-3 bg-blue-50 border border-blue-200 rounded">
                        <div class="flex items-center">
                            <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm text-blue-700 font-light">Analyse de l'image en cours...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fichiers audio -->
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Fichiers audio</h2>

                <div class="space-y-4">
                    <div>
                        <label for="audio_fr" class="block text-sm font-light text-gray-700 tracking-wide mb-2">AUDIO FRANÇAIS</label>
                        <input type="file" name="audio_fr" id="audio_fr" accept="audio/*"
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                        <p class="mt-1 text-xs text-gray-500 font-light">MP3, WAV, OGG - Max 10MB</p>
                        @error('audio_fr')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="audio_en" class="block text-sm font-light text-gray-700 tracking-wide mb-2">AUDIO ANGLAIS</label>
                        <input type="file" name="audio_en" id="audio_en" accept="audio/*"
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                        @error('audio_en')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="audio_wo" class="block text-sm font-light text-gray-700 tracking-wide mb-2">AUDIO WOLOF</label>
                        <input type="file" name="audio_wo" id="audio_wo" accept="audio/*"
                               class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                        @error('audio_wo')
                            <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Vidéo -->
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Vidéo explicative</h2>

                <div>
                    <label for="video" class="block text-sm font-light text-gray-700 tracking-wide mb-2">VIDÉO</label>
                    <input type="file" name="video" id="video" accept="video/*"
                           class="w-full px-3 py-2 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light">
                    <p class="mt-1 text-xs text-gray-500 font-light">MP4, AVI, MOV - Max 50MB</p>
                    @error('video')
                        <p class="mt-1 text-sm text-red-600 font-light">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Options -->
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-light text-gray-900 tracking-wide mb-6">Options</h2>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="h-4 w-4 text-gray-600 border-gray-300 rounded focus:ring-gray-500">
                        <label for="is_featured" class="ml-2 text-sm font-light text-gray-700 tracking-wide">Coup de cœur</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-gray-600 border-gray-300 rounded focus:ring-gray-500">
                        <label for="is_active" class="ml-2 text-sm font-light text-gray-700 tracking-wide">Œuvre active</label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-sm border border-gray-200 p-6">
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 py-3 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
                        Créer l'œuvre
                    </button>
                    <a href="{{ route('admin.artworks.index') }}" class="flex-1 py-3 border border-gray-300 text-gray-700 text-sm font-light tracking-wide hover:bg-gray-50 transition-colors duration-200 text-center">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const analyzeBtn = document.getElementById('analyze-image-btn');
    const imagePreview = document.getElementById('image-preview');
    const analyzingMessage = document.getElementById('analyzing-message');

    // Afficher le bouton d'analyse et la prévisualisation quand une image est sélectionnée
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Afficher la prévisualisation
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);

            // Afficher le bouton d'analyse
            analyzeBtn.classList.remove('hidden');
        } else {
            imagePreview.classList.add('hidden');
            analyzeBtn.classList.add('hidden');
        }
    });

    // Gérer le clic sur le bouton d'analyse
    analyzeBtn.addEventListener('click', async function() {
        const file = imageInput.files[0];
        if (!file) {
            alert('Veuillez d\'abord sélectionner une image');
            return;
        }

        // Afficher le message de chargement
        analyzingMessage.classList.remove('hidden');
        analyzeBtn.disabled = true;
        analyzeBtn.innerHTML = '<svg class="inline-block animate-spin h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Analyse en cours...';

        // Créer le FormData
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');

        try {
            const response = await fetch('{{ route('admin.artworks.analyze-image') }}', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            console.log('Réponse complète:', result);

            if (result.success && result.data) {
                // Remplir les champs avec les données analysées
                const data = result.data;
                console.log('Données reçues:', data);

                // Remplir le titre
                if (data.title_fr && data.title_fr.trim() !== '') {
                    console.log('Remplissage titre:', data.title_fr);
                    document.getElementById('title').value = data.title_fr;
                }

                // Remplir l'artiste
                if (data.artist && data.artist.trim() !== '') {
                    console.log('Remplissage artiste:', data.artist);
                    document.getElementById('artist').value = data.artist;
                }

                // Remplir l'année
                if (data.year && data.year.toString().trim() !== '') {
                    console.log('Remplissage année:', data.year);
                    document.getElementById('creation_year').value = data.year;
                }

                // Remplir les descriptions
                if (data.description_fr && data.description_fr.trim() !== '') {
                    console.log('Remplissage description FR');
                    document.getElementById('description_fr').value = data.description_fr;
                }

                if (data.description_en && data.description_en.trim() !== '') {
                    console.log('Remplissage description EN');
                    document.getElementById('description_en').value = data.description_en;
                }

                if (data.description_wo && data.description_wo.trim() !== '') {
                    console.log('Remplissage description WO');
                    document.getElementById('description_wo').value = data.description_wo;
                }

                // Remplir le contexte culturel
                if (data.cultural_context && data.cultural_context.trim() !== '') {
                    console.log('Remplissage contexte culturel');
                    document.getElementById('cultural_significance').value = data.cultural_context;
                }

                // Afficher un message de succès
                showNotification('Analyse réussie ! Les champs ont été remplis automatiquement.', 'success');
            } else {
                console.error('Erreur dans la réponse:', result);
                showNotification('Erreur lors de l\'analyse: ' + (result.message || 'Erreur inconnue'), 'error');
            }
        } catch (error) {
            console.error('Erreur complète:', error);
            showNotification('Erreur lors de l\'analyse de l\'image: ' + error.message, 'error');
        } finally {
            // Cacher le message de chargement
            analyzingMessage.classList.add('hidden');
            analyzeBtn.disabled = false;
            analyzeBtn.innerHTML = '<svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Analyser avec IA';
        }
    });

    // Fonction pour afficher les notifications
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white max-w-md`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="font-light">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        document.body.appendChild(notification);

        // Supprimer automatiquement après 5 secondes
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
});
</script>
@endpush
@endsection