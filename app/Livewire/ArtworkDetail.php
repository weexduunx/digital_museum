<?php

namespace App\Livewire;

use App\Models\Artwork;
use App\Services\TextToSpeechService;
use App\Services\UniversalTTSService;
use Livewire\Component;

class ArtworkDetail extends Component
{
    public Artwork $artwork;
    public $currentLanguage = 'fr';
    public $isPlaying = false;
    public $useAI = false; // Prefer browser TTS by default

    public function mount(Artwork $artwork)
    {
        $this->artwork = $artwork;
        $this->currentLanguage = app()->getLocale();
    }

    public function switchLanguage($language)
    {
        $this->currentLanguage = $language;
        $this->isPlaying = false; // Reset audio state when switching language
    }

    public function toggleAudio()
    {
        $this->isPlaying = !$this->isPlaying;
    }

    public function toggleAIMode()
    {
        $this->useAI = !$this->useAI;
        $this->isPlaying = false; // Reset audio state
    }

    public function generateAIAudio()
    {
        if (!$this->useAI) return;

        $tts = new UniversalTTSService();
        $description = $this->description;

        if ($description) {
            $audioPath = $tts->generateAudio($description, $this->currentLanguage);
            if ($audioPath) {
                // Update the artwork with the generated audio path
                $field = 'audio_path_' . $this->currentLanguage;
                $this->artwork->update([$field => $audioPath]);
                $this->artwork->refresh();

                session()->flash('audio_generated', 'Audio généré avec succès !');
            } else {
                session()->flash('audio_error', 'Aucun service TTS disponible. Configurez une clé API ou utilisez le mode navigateur.');
            }
        }
    }

    public function getAvailableProvidersProperty()
    {
        $tts = new UniversalTTSService();
        return $tts->getAvailableProviders();
    }

    public function getDescriptionProperty()
    {
        return match($this->currentLanguage) {
            'en' => $this->artwork->description_en ?? $this->artwork->description_fr,
            'wo' => $this->artwork->description_wo ?? $this->artwork->description_fr,
            default => $this->artwork->description_fr,
        };
    }

    public function getAudioPathProperty()
    {
        return match($this->currentLanguage) {
            'en' => $this->artwork->audio_path_en,
            'wo' => $this->artwork->audio_path_wo,
            default => $this->artwork->audio_path_fr,
        };
    }

    public function render()
    {
        return view('livewire.artwork-detail');
    }
}
