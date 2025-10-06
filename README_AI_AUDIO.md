# 🎙️ Guide Audio IA - Digital Museum

## 🚀 Fonctionnalités Implémentées

### 1. **Synthèse Vocale avec IA (OpenAI TTS)**
- **Service**: `App\Services\TextToSpeechService`
- **API**: OpenAI Text-to-Speech API
- **Formats supportés**: MP3
- **Langues**: Français, Anglais, Wolof (avec voix optimisées)

### 2. **Interface Audio Intelligente**
- **Mode IA** 🤖: Génération audio en temps réel
- **Mode Fichier** 📄: Audio pré-enregistré
- **Basculement dynamique** entre les deux modes

### 3. **Fonctionnalités Inclusives**
- **Synthèse vocale du navigateur** (fallback)
- **Multilingue**: Support automatique selon la langue sélectionnée
- **Interface accessible** avec contrôles visuels

## ⚙️ Configuration

### 1. Clé API OpenAI
```bash
# Dans votre fichier .env
OPENAI_API_KEY=your_openai_api_key_here
```

### 2. Voix par Langue
- **Français**: `nova` (voix féminine naturelle)
- **Anglais**: `alloy` (voix masculine claire)
- **Wolof**: `echo` (voix alternative)

## 🎯 Utilisation

### Interface Utilisateur
1. **Visitez une fiche d'œuvre**: `/artwork/{qr_code}`
2. **Section Audio**: Affichage automatique des options
3. **Mode IA**: Cliquez sur "🎙️ Générer audio IA"
4. **Mode Navigateur**: Bouton "🔊 Écouter (Navigateur)" pour l'immédiat

### Génération Audio
```php
// Dans votre contrôleur ou composant Livewire
use App\Services\TextToSpeechService;

$tts = new TextToSpeechService();
$audioPath = $tts->generateAudio($description, $language);
```

## 🌟 Avantages

### ✅ **Expérience Inclusive**
- Accessibilité pour les personnes malvoyantes
- Support multilingue complet
- Qualité vocale professionnelle

### ✅ **Flexibilité Technique**
- **Génération à la demande** (économique)
- **Fallback navigateur** (toujours disponible)
- **Cache automatique** des fichiers générés

### ✅ **UX Optimisée**
- Interface intuitive avec icônes
- Feedback visuel (loading, états)
- Basculement entre modes sans rechargement

## 🔧 Architecture

```
app/
├── Services/
│   └── TextToSpeechService.php     # Service principal TTS
├── Livewire/
│   └── ArtworkDetail.php           # Composant avec logique audio
└── Http/Controllers/
    └── ArtworkController.php       # Contrôleur des œuvres

resources/views/livewire/
└── artwork-detail.blade.php        # Interface audio complète

storage/app/public/audio/
├── generated/                      # Audio généré par IA
└── [existing audio files]          # Audio pré-enregistré
```

## 🎨 Démo

**Serveur**: http://127.0.0.1:8001
**Exemple**: http://127.0.0.1:8001/artwork/MASK_DIOLA_001

### Interface Audio:
- 🤖 **Mode IA**: Génération en temps réel
- 📄 **Mode Fichier**: Audio traditionnel
- 🔊 **Navigateur**: Synthèse locale immédiate
- 🔄 **Basculement**: Un clic pour changer de mode

---

## 💡 Notes Techniques

- **Coût optimisé**: Génération uniquement à la demande
- **Performance**: Cache des fichiers générés
- **Accessibilité**: Conforme aux standards WCAG
- **Responsive**: Interface adaptée mobile/desktop

Cette implémentation transforme votre musée numérique en expérience **véritablement inclusive** ! 🏛️✨