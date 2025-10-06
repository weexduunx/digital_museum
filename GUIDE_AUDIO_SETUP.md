# 🎙️ Guide de Configuration Audio IA

## 🗝️ Options de Clés API

### **Option 1: OpenAI (Recommandé)**
```bash
# Étapes pour obtenir une clé OpenAI:
# 1. Aller sur https://platform.openai.com
# 2. Créer un compte ou se connecter
# 3. Aller dans "API Keys"
# 4. Cliquer "Create new secret key"
# 5. Copier la clé dans votre .env

OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

**💰 Coût**: ~$0.015 par 1000 caractères (très abordable)
**✅ Qualité**: Excellent, voix naturelles
**🌍 Langues**: 50+ langues supportées

---

### **Option 2: Solutions Gratuites (Sans API)**

#### **A. Synthèse Vocale du Navigateur (Déjà implémentée)**
- ✅ **Gratuit** et immédiatement disponible
- ✅ Fonctionne **sans configuration**
- ✅ Support multilingue
- ⚠️ Qualité variable selon navigateur

#### **B. Edge TTS (Microsoft) - GRATUIT**
```bash
# Installation
npm install edge-tts

# Exemple d'utilisation
edge-tts --voice "fr-FR-DeniseNeural" --text "Votre texte" --write-media audio.mp3
```

#### **C. Google Cloud TTS (Gratuit jusqu'à 1M caractères/mois)**
```bash
# Clé Google Cloud
GOOGLE_CLOUD_TTS_KEY=your_google_key_here
```

---

### **Option 3: Anthropic Claude (Expérimental)**

**⚠️ Note**: Claude n'a pas encore d'API TTS officielle, mais voici comment l'intégrer quand disponible:

```bash
# Configuration future
ANTHROPIC_API_KEY=your_claude_key_here
```

---

## 🛠️ **Implémentation Multi-Providers**

Le système utilise maintenant `UniversalTTSService` qui teste automatiquement les providers disponibles :

### **🎯 Solutions IMMÉDIATES (Sans API)**

#### **1. Mode Navigateur (Déjà fonctionnel)**
- ✅ **0 configuration** requise
- ✅ Fonctionne **maintenant** sur votre projet
- ✅ Qualité correcte sur navigateurs modernes

#### **2. Edge TTS (Microsoft - GRATUIT)**
```bash
# Installation simple
npm install -g edge-tts

# Test immédiat
edge-tts --voice "fr-FR-DeniseNeural" --text "Test audio" --write-media test.mp3
```

**✅ Avantages**:
- Complètement gratuit
- Qualité excellente (voix neurales Microsoft)
- Aucune limite d'usage
- Support 100+ langues

---

## 📋 **Guide Rapide d'Installation**

### **Option A: Sans aucune API (Recommandé pour débuter)**
1. ✅ **Déjà fonctionnel** : Le mode navigateur marche immédiatement
2. Optionnel : Installer Edge TTS pour améliorer la qualité

### **Option B: OpenAI (Payant mais excellent)**
1. Aller sur https://platform.openai.com
2. Créer un compte
3. Aller dans "API Keys" → "Create new secret key"
4. Ajouter dans `.env`: `OPENAI_API_KEY=sk-xxxxxxx`
5. **Coût**: ~1.5¢ par 1000 caractères

### **Option C: Google Cloud (1M caractères gratuits/mois)**
1. Aller sur https://console.cloud.google.com
2. Activer "Cloud Text-to-Speech API"
3. Créer une clé API
4. Ajouter dans `.env`: `GOOGLE_CLOUD_TTS_KEY=your_key`

---

## 🔧 **Configuration .env Complète**

```bash
# TTS APIs (ajoutez seulement celles que vous voulez utiliser)
OPENAI_API_KEY=your_openai_key_here
GOOGLE_CLOUD_TTS_KEY=your_google_key_here
ANTHROPIC_API_KEY=your_claude_key_here

# Si aucune API configurée, le système utilisera:
# 1. Synthèse vocale du navigateur (toujours disponible)
# 2. Edge TTS si installé
```

---

## 🎪 **Comment ça marche**

Le `UniversalTTSService` teste automatiquement dans cet ordre :
1. **OpenAI** (si clé configurée) - Qualité premium
2. **Edge TTS** (si installé) - Gratuit, excellente qualité
3. **Google Cloud** (si clé configurée) - Freemium
4. **Navigateur** (toujours disponible) - Fallback immédiat

**🎯 Résultat** : Votre application fonctionne **immédiatement** même sans aucune configuration !

---

## 📱 **Test Immédiat**

1. Visitez : http://127.0.0.1:8001/artwork/MASK_DIOLA_001
2. Cliquez sur **"🔊 Écouter (Navigateur)"**
3. ✅ L'audio fonctionne **sans aucune configuration** !

Pour améliorer la qualité, ajoutez une clé API selon vos besoins.