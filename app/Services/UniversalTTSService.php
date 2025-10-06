<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class UniversalTTSService
{
    private $providers = [];

    public function __construct()
    {
        // Auto-detect available providers
        $this->detectProviders();
    }

    /**
     * Detect which TTS providers are available
     */
    private function detectProviders()
    {
        // OpenAI TTS
        if (config('services.openai.api_key') && config('services.openai.api_key') !== 'your_openai_api_key_here') {
            $this->providers['openai'] = true;
        }

        // Google Cloud TTS
        if (config('services.google_tts.api_key')) {
            $this->providers['google'] = true;
        }

        // Edge TTS (check if edge-tts is available)
        if ($this->isEdgeTTSAvailable()) {
            $this->providers['edge'] = true;
        }

        // Browser TTS (always available as fallback)
        $this->providers['browser'] = true;

        Log::info('TTS Providers detected: ' . json_encode(array_keys($this->providers)));
    }

    /**
     * Generate audio using the best available provider
     */
    public function generateAudio(string $text, string $language = 'fr'): ?string
    {
        // Try providers in order of preference
        $providers = ['openai', 'edge', 'google'];

        foreach ($providers as $provider) {
            if (isset($this->providers[$provider])) {
                try {
                    $result = $this->{'generate' . ucfirst($provider) . 'Audio'}($text, $language);
                    if ($result) {
                        Log::info("Audio generated successfully with {$provider}");
                        return $result;
                    }
                } catch (\Exception $e) {
                    Log::warning("Provider {$provider} failed: " . $e->getMessage());
                    continue;
                }
            }
        }

        Log::error('All TTS providers failed');
        return null;
    }

    /**
     * OpenAI TTS (Premium)
     */
    private function generateOpenaiAudio(string $text, string $language): ?string
    {
        $voiceMap = [
            'fr' => 'nova',
            'en' => 'alloy',
            'wo' => 'echo'
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/audio/speech', [
            'model' => 'tts-1',
            'input' => $text,
            'voice' => $voiceMap[$language] ?? 'nova',
            'response_format' => 'mp3'
        ]);

        if ($response->successful()) {
            $filename = 'audio/generated/openai_' . uniqid() . '_' . $language . '.mp3';
            Storage::disk('public')->put($filename, $response->body());
            return $filename;
        }

        return null;
    }

    /**
     * Edge TTS (Free Microsoft)
     */
    private function generateEdgeAudio(string $text, string $language): ?string
    {
        $voiceMap = [
            'fr' => 'fr-FR-DeniseNeural',
            'en' => 'en-US-AriaNeural',
            'wo' => 'fr-FR-DeniseNeural' // Fallback to French for Wolof
        ];

        $filename = 'audio/generated/edge_' . uniqid() . '_' . $language . '.mp3';
        $fullPath = storage_path('app/public/' . $filename);

        // Create directory if it doesn't exist
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Use edge-tts command
        $voice = $voiceMap[$language] ?? 'fr-FR-DeniseNeural';
        $command = "edge-tts --voice \"{$voice}\" --text " . escapeshellarg($text) . " --write-media \"{$fullPath}\"";

        $result = Process::run($command);

        if ($result->successful() && file_exists($fullPath)) {
            return $filename;
        }

        return null;
    }

    /**
     * Google Cloud TTS
     */
    private function generateGoogleAudio(string $text, string $language): ?string
    {
        $languageMap = [
            'fr' => 'fr-FR',
            'en' => 'en-US',
            'wo' => 'fr-FR' // Fallback
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Goog-Api-Key' => config('services.google_tts.api_key'),
        ])->post('https://texttospeech.googleapis.com/v1/text:synthesize', [
            'input' => ['text' => $text],
            'voice' => [
                'languageCode' => $languageMap[$language] ?? 'fr-FR',
                'ssmlGender' => 'FEMALE'
            ],
            'audioConfig' => [
                'audioEncoding' => 'MP3'
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $audioContent = base64_decode($data['audioContent']);

            $filename = 'audio/generated/google_' . uniqid() . '_' . $language . '.mp3';
            Storage::disk('public')->put($filename, $audioContent);
            return $filename;
        }

        return null;
    }

    /**
     * Check if Edge TTS is available
     */
    private function isEdgeTTSAvailable(): bool
    {
        try {
            $result = Process::run('edge-tts --help');
            return $result->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get available providers for display
     */
    public function getAvailableProviders(): array
    {
        $providers = [];

        if (isset($this->providers['openai'])) {
            $providers[] = ['name' => 'OpenAI', 'type' => 'premium', 'quality' => 'excellent'];
        }

        if (isset($this->providers['edge'])) {
            $providers[] = ['name' => 'Microsoft Edge', 'type' => 'free', 'quality' => 'good'];
        }

        if (isset($this->providers['google'])) {
            $providers[] = ['name' => 'Google Cloud', 'type' => 'freemium', 'quality' => 'excellent'];
        }

        $providers[] = ['name' => 'Navigateur', 'type' => 'free', 'quality' => 'variable'];

        return $providers;
    }

    /**
     * Get JavaScript for browser TTS fallback
     */
    public function getBrowserTTSScript(): string
    {
        return '
        function speakWithBrowser(text, lang) {
            if ("speechSynthesis" in window) {
                speechSynthesis.cancel(); // Stop any current speech

                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = lang === "wo" ? "fr" : lang; // Wolof fallback to French
                utterance.rate = 0.9;
                utterance.pitch = 1;

                // Try to find a good voice
                const voices = speechSynthesis.getVoices();
                const preferredVoice = voices.find(voice =>
                    voice.lang.startsWith(utterance.lang) &&
                    (voice.name.includes("Female") || voice.name.includes("Neural"))
                );

                if (preferredVoice) {
                    utterance.voice = preferredVoice;
                }

                speechSynthesis.speak(utterance);

                return true;
            }

            alert("Synthèse vocale non supportée dans ce navigateur");
            return false;
        }
        ';
    }
}