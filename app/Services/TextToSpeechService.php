<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TextToSpeechService
{
    private $apiKey;
    private $baseUrl = 'https://api.openai.com/v1/audio/speech';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

    /**
     * Generate audio from text using OpenAI TTS
     */
    public function generateAudio(string $text, string $language = 'fr', string $voice = 'nova'): ?string
    {
        try {
            // Configure voice based on language
            $voiceMap = [
                'fr' => 'nova',    // French voice
                'en' => 'alloy',   // English voice
                'wo' => 'echo'     // Wolof (using alternative voice)
            ];

            $selectedVoice = $voiceMap[$language] ?? 'nova';

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, [
                'model' => 'tts-1',
                'input' => $text,
                'voice' => $selectedVoice,
                'response_format' => 'mp3'
            ]);

            if ($response->successful()) {
                // Generate unique filename
                $filename = 'audio/generated/' . uniqid() . '_' . $language . '.mp3';

                // Save audio file
                Storage::disk('public')->put($filename, $response->body());

                return $filename;
            }

            Log::error('TTS API Error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('TTS Service Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate audio for all languages of an artwork description
     */
    public function generateArtworkAudio($artwork): array
    {
        $audioPaths = [];

        // Generate French audio
        if ($artwork->description_fr) {
            $audioPaths['fr'] = $this->generateAudio($artwork->description_fr, 'fr');
        }

        // Generate English audio
        if ($artwork->description_en) {
            $audioPaths['en'] = $this->generateAudio($artwork->description_en, 'en');
        }

        // Generate Wolof audio
        if ($artwork->description_wo) {
            $audioPaths['wo'] = $this->generateAudio($artwork->description_wo, 'wo');
        }

        return $audioPaths;
    }

    /**
     * Fallback: Use browser's Web Speech API for TTS (client-side)
     */
    public function generateBrowserTTS(): string
    {
        return '
        <script>
        function speakText(text, lang) {
            if ("speechSynthesis" in window) {
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = lang;

                // Set voice based on language
                const voices = speechSynthesis.getVoices();
                const voice = voices.find(v => v.lang.startsWith(lang.substring(0,2)));
                if (voice) utterance.voice = voice;

                speechSynthesis.speak(utterance);
            } else {
                alert("Synthèse vocale non supportée dans ce navigateur");
            }
        }
        </script>';
    }
}