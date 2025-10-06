<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="space-y-6">
        <div class="relative bg-white rounded-xl shadow-lg overflow-hidden">
            @if($artwork->image_path)
                <img
                    src="{{ asset('storage/' . $artwork->image_path) }}"
                    alt="{{ $artwork->title }}"
                    class="w-full h-96 lg:h-[500px] object-cover"
                >
            @else
                <div class="w-full h-96 lg:h-[500px] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            @if($artwork->is_featured)
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Coup de cœur
                    </span>
                </div>
            @endif
        </div>

        @if($artwork->video_path)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Vidéo explicative</h3>
                </div>
                <div class="aspect-video">
                    <video controls class="w-full h-full">
                        <source src="{{ asset('storage/' . $artwork->video_path) }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                </div>
            </div>
        @endif
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $artwork->title }}</h1>
                    <p class="text-xl text-gray-600 mb-1">{{ $artwork->artist }}</p>
                    @if($artwork->creation_year)
                        <p class="text-gray-500">{{ $artwork->creation_year }}</p>
                    @endif
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: {{ $artwork->category->color }}">
                    {{ $artwork->category->name }}
                </span>
            </div>

            @if($artwork->medium || $artwork->dimensions)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                    @if($artwork->medium)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Technique</dt>
                            <dd class="text-sm text-gray-900">{{ $artwork->medium }}</dd>
                        </div>
                    @endif
                    @if($artwork->dimensions)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dimensions</dt>
                            <dd class="text-sm text-gray-900">{{ $artwork->dimensions }}</dd>
                        </div>
                    @endif
                </div>
            @endif

            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Description</h2>
                    <div class="flex space-x-2">
                        <button
                            wire:click="switchLanguage('fr')"
                            class="px-3 py-1 text-xs font-medium rounded-full transition-colors duration-200 {{ $currentLanguage === 'fr' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                        >
                            🇫🇷 FR
                        </button>
                        <button
                            wire:click="switchLanguage('en')"
                            class="px-3 py-1 text-xs font-medium rounded-full transition-colors duration-200 {{ $currentLanguage === 'en' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                        >
                            🇬🇧 EN
                        </button>
                        <button
                            wire:click="switchLanguage('wo')"
                            class="px-3 py-1 text-xs font-medium rounded-full transition-colors duration-200 {{ $currentLanguage === 'wo' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                        >
                            🇸🇳 WO
                        </button>
                    </div>
                </div>

                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-700 leading-relaxed">{{ $this->description }}</p>
                </div>

                <!-- Audio Section -->
                <div class="mt-4 p-4 bg-indigo-50 rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M8.586 17.414A2 2 0 118.586 6.586l8.828 8.828-2.828 2.828a2 2 0 01-2.828 0l-8.828-8.828z"/>
                            </svg>
                            <span class="text-sm font-medium text-indigo-900">Guide audio de la description</span>
                        </div>

                        <div class="text-xs text-gray-500 bg-white px-2 py-1 rounded">
                            {{ strtoupper($currentLanguage) }}
                        </div>
                    </div>

                    <!-- Main Browser TTS Section -->
                    <div x-data="{
                        speaking: false,
                        canSpeak: 'speechSynthesis' in window,
                        currentUtterance: null
                    }" class="space-y-3">

                        <!-- Browser TTS - Main Option -->
                        <div class="bg-white rounded-lg p-4 border border-indigo-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Écouter la description</p>
                                        <p class="text-sm text-gray-500">Synthèse vocale instantanée</p>
                                    </div>
                                </div>

                                <button
                                    x-show="canSpeak"
                                    @click="
                                        if (!speaking) {
                                            speaking = true;
                                            const text = '{{ addslashes($this->description) }}';
                                            const lang = '{{ $currentLanguage === 'wo' ? 'fr' : $currentLanguage }}';
                                            currentUtterance = new SpeechSynthesisUtterance(text);
                                            currentUtterance.lang = lang;
                                            currentUtterance.rate = 0.9;
                                            currentUtterance.pitch = 1;

                                            // Try to find a good voice
                                            const voices = speechSynthesis.getVoices();
                                            const preferredVoice = voices.find(voice =>
                                                voice.lang.startsWith(lang) &&
                                                (voice.name.includes('Female') || voice.name.includes('Neural') || voice.name.includes('Natural'))
                                            );
                                            if (preferredVoice) currentUtterance.voice = preferredVoice;

                                            currentUtterance.onend = () => { speaking = false; currentUtterance = null; };
                                            currentUtterance.onerror = () => { speaking = false; currentUtterance = null; };

                                            speechSynthesis.speak(currentUtterance);
                                        } else {
                                            speechSynthesis.cancel();
                                            speaking = false;
                                            currentUtterance = null;
                                        }
                                    "
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm"
                                    x-text="speaking ? '⏹️ Arrêter' : '🔊 Écouter'"
                                >
                                </button>

                                <div x-show="!canSpeak" class="text-sm text-red-600">
                                    Synthèse vocale non supportée
                                </div>
                            </div>

                            <!-- Audio Progress Indicator -->
                            <div x-show="speaking" class="mt-3">
                                <div class="flex items-center text-sm text-indigo-600">
                                    <svg class="animate-pulse w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.816L4.846 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.846l3.537-3.816z" clip-rule="evenodd"/>
                                        <path d="M11.786 7.457a.5.5 0 01.707 0 4.5 4.5 0 010 6.364.5.5 0 01-.707-.707 3.5 3.5 0 000-4.95.5.5 0 010-.707z"/>
                                        <path d="M13.39 5.853a.5.5 0 01.707 0 7.5 7.5 0 010 10.607.5.5 0 01-.707-.707 6.5 6.5 0 000-9.193.5.5 0 010-.707z"/>
                                    </svg>
                                    Lecture en cours...
                                </div>
                            </div>
                        </div>

                        <!-- Alternative: File Audio (if available) -->
                        @if($this->audioPath)
                            <details class="bg-gray-50 rounded-lg">
                                <summary class="cursor-pointer p-3 text-sm text-gray-600 hover:text-gray-800">
                                    📄 Alternative : Audio prédéfini disponible
                                </summary>
                                <div class="p-3 pt-0">
                                    <audio class="w-full" controls>
                                        <source src="{{ asset('storage/' . $this->audioPath) }}" type="audio/mpeg">
                                        Votre navigateur ne supporte pas l'audio.
                                    </audio>
                                </div>
                            </details>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($artwork->historical_context && count($artwork->historical_context))
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Contexte historique</h2>
                <div class="space-y-3">
                    @foreach($artwork->historical_context as $context)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-indigo-600 rounded-full mt-2 mr-3"></div>
                            <p class="text-gray-700">{{ $context }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($artwork->cultural_significance && count($artwork->cultural_significance))
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Signification culturelle</h2>
                <div class="space-y-3">
                    @foreach($artwork->cultural_significance as $significance)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-purple-600 rounded-full mt-2 mr-3"></div>
                            <p class="text-gray-700">{{ $significance }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Partager cette œuvre</h2>
            <div class="flex items-center space-x-4">
                <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                    </svg>
                    Partager
                </button>

                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Imprimer
                </button>
            </div>

            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 mb-1">Code QR de cette œuvre :</p>
                <p class="text-sm font-mono text-gray-700 mb-3">{{ $artwork->qr_code }}</p>

                <div class="flex items-center justify-between">
                    <div class="text-center">
                        <img src="{{ route('qr.generate', $artwork->qr_code) }}" alt="QR Code" class="w-16 h-16 mx-auto border border-gray-300 rounded mb-1">
                        <p class="text-xs text-gray-500">QR Code</p>
                    </div>

                    <div class="flex space-x-2">
                        <a href="{{ route('qr.generate', $artwork->qr_code) }}"
                           target="_blank"
                           class="px-3 py-1 text-xs bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200">
                            Agrandir
                        </a>
                        <a href="{{ route('qr.gallery') }}"
                           class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Tous les QR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
