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
                    <span class="inline-block px-4 py-2 text-sm font-light tracking-wide text-white bg-black/80 backdrop-blur-sm">
                        COUP DE CŒUR
                    </span>
                </div>
            @endif
        </div>

        @if($artwork->video_path)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-light text-gray-900 tracking-wide">Vidéo explicative</h3>
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
                    <h1 class="text-4xl font-light text-gray-900 mb-4 leading-tight tracking-tight">{{ $artwork->title }}</h1>
                    <p class="text-xl text-gray-600 mb-2 font-light tracking-wide">{{ $artwork->artist }}</p>
                    @if($artwork->creation_year)
                        <p class="text-gray-500 font-light tracking-wide">{{ $artwork->creation_year }}</p>
                    @endif
                </div>
                <span class="inline-block px-4 py-2 text-sm font-light tracking-widest text-white" style="background-color: {{ $artwork->category->color }}">
                    {{ strtoupper($artwork->category->name) }}
                </span>
            </div>

            @if($artwork->medium || $artwork->dimensions)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
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
                </div>
            @endif

            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-light text-gray-900 tracking-wide">Description</h2>
                    <div class="flex space-x-2">
                        <button
                            wire:click="switchLanguage('fr')"
                            class="px-3 py-1 text-xs font-light tracking-wide transition-colors duration-200 {{ $currentLanguage === 'fr' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                        >
                            🇫🇷 FR
                        </button>
                        <button
                            wire:click="switchLanguage('en')"
                            class="px-3 py-1 text-xs font-light tracking-wide transition-colors duration-200 {{ $currentLanguage === 'en' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                        >
                            🇬🇧 EN
                        </button>
                        <button
                            wire:click="switchLanguage('wo')"
                            class="px-3 py-1 text-xs font-light tracking-wide transition-colors duration-200 {{ $currentLanguage === 'wo' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                        >
                            🇸🇳 WO
                        </button>
                    </div>
                </div>

                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-700 leading-relaxed font-light">{{ $this->description }}</p>
                </div>

                <!-- Audio Section -->
                <div class="mt-4 p-4 bg-indigo-50 rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M8.586 17.414A2 2 0 118.586 6.586l8.828 8.828-2.828 2.828a2 2 0 01-2.828 0l-8.828-8.828z"/>
                            </svg>
                            <span class="text-sm font-light text-gray-900 tracking-wide">Guide audio de la description</span>
                        </div>

                        <div class="text-xs text-gray-500 bg-white px-2 py-1 rounded">
                            {{ strtoupper($currentLanguage) }}
                        </div>
                    </div>

                    <!-- Main Browser TTS Section -->
                    <div x-data="speechController()" class="space-y-3">

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
                                        <p class="font-light text-gray-900 tracking-wide">Écouter la description</p>
                                        <p class="text-sm text-gray-500 font-light">Synthèse vocale instantanée</p>
                                    </div>
                                </div>

                                <button
                                    x-show="canSpeak"
                                    @click="toggleSpeech()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-900 text-white hover:bg-gray-800 transition-colors duration-200 shadow-sm font-light tracking-wide"
                                    x-text="speaking ? '⏹️ Arrêter' : '🔊 Écouter'"
                                >
                                </button>

                                <div x-show="!canSpeak" class="text-sm text-red-600">
                                    Synthèse vocale non supportée
                                </div>
                            </div>

                            <!-- Audio Progress Indicator -->
                            <div x-show="speaking" class="mt-3">
                                <div class="flex items-center text-sm text-gray-600 font-light">
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
                <h2 class="text-2xl font-light text-gray-900 mb-6 tracking-wide">Contexte historique</h2>
                <div class="space-y-3">
                    @foreach($artwork->historical_context as $context)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-indigo-600 rounded-full mt-2 mr-3"></div>
                            <p class="text-gray-700 font-light leading-relaxed">{{ $context }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($artwork->cultural_significance && count($artwork->cultural_significance))
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-light text-gray-900 mb-6 tracking-wide">Signification culturelle</h2>
                <div class="space-y-3">
                    @foreach($artwork->cultural_significance as $significance)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-purple-600 rounded-full mt-2 mr-3"></div>
                            <p class="text-gray-700 font-light leading-relaxed">{{ $significance }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-light text-gray-900 mb-6 tracking-wide">Partager cette œuvre</h2>
            <div class="flex items-center space-x-4">
                <button class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-light tracking-wide text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                    </svg>
                    Partager
                </button>

                <button onclick="window.print()" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-light tracking-wide text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Imprimer
                </button>
            </div>

            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 mb-1 font-light tracking-wide">CODE QR DE CETTE ŒUVRE :</p>
                <p class="text-sm font-mono text-gray-700 mb-3 font-light">{{ $artwork->qr_code }}</p>

                <div class="flex items-center justify-between">
                    <div class="text-center">
                        <img src="{{ route('qr.generate', $artwork->qr_code) }}" alt="QR Code" class="w-16 h-16 mx-auto border border-gray-300 rounded mb-1">
                        <p class="text-xs text-gray-500 font-light tracking-widest">QR CODE</p>
                    </div>

                    <div class="flex space-x-2">
                        <a href="{{ route('qr.generate', $artwork->qr_code) }}"
                           target="_blank"
                           class="px-3 py-1 text-xs bg-gray-900 text-white hover:bg-gray-800 transition-colors duration-200 font-light tracking-wide">
                            AGRANDIR
                        </a>
                        <a href="{{ route('qr.gallery') }}"
                           class="px-3 py-1 text-xs bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors duration-200 font-light tracking-wide">
                            TOUS LES QR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function speechController() {
    return {
        speaking: false,
        canSpeak: 'speechSynthesis' in window,
        currentUtterance: null,
        text: @js($this->description),
        lang: @js($currentLanguage === 'wo' ? 'fr' : $currentLanguage),

        toggleSpeech() {
            if (!this.speaking) {
                this.startSpeech();
            } else {
                this.stopSpeech();
            }
        },

        startSpeech() {
            this.speaking = true;
            this.currentUtterance = new SpeechSynthesisUtterance(this.text);
            this.currentUtterance.lang = this.lang;
            this.currentUtterance.rate = 0.9;
            this.currentUtterance.pitch = 1;

            // Try to find a good voice
            const voices = speechSynthesis.getVoices();
            const preferredVoice = voices.find(voice =>
                voice.lang.startsWith(this.lang) &&
                (voice.name.includes('Female') || voice.name.includes('Neural') || voice.name.includes('Natural'))
            );
            if (preferredVoice) {
                this.currentUtterance.voice = preferredVoice;
            }

            this.currentUtterance.onend = () => {
                this.speaking = false;
                this.currentUtterance = null;
            };

            this.currentUtterance.onerror = () => {
                this.speaking = false;
                this.currentUtterance = null;
            };

            speechSynthesis.speak(this.currentUtterance);
        },

        stopSpeech() {
            speechSynthesis.cancel();
            this.speaking = false;
            this.currentUtterance = null;
        }
    };
}
</script>
@endpush
