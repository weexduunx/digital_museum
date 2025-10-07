# 🏛️ Musée Digital des Civilisations Noires

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-purple.svg)](https://livewire.laravel.com)
[![PWA](https://img.shields.io/badge/PWA-Ready-green.svg)](https://web.dev/progressive-web-apps/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

> **Une plateforme numérique révolutionnaire pour démocratiser l'accès au patrimoine culturel africain**

## 🌟 Vue d'ensemble

Le **Musée Digital des Civilisations Noires** est une solution innovante qui transforme l'expérience muséale traditionnelle en une aventure numérique immersive. Grâce aux QR codes intelligents, descriptions multilingues, guides audio adaptatifs et visites virtuelles 3D, nous rendons le patrimoine culturel accessible à tous, partout dans le monde.

### ✨ Fonctionnalités principales

- 🔍 **Scan QR intelligent** - Accès instantané aux fiches descriptives complètes
- 🌍 **Multilingue** - Support Français, Anglais et Wolof
- 🎧 **Audio inclusif** - Synthèse vocale + guides audio prédéfinis
- 🎮 **Visite 3D** - Environnement immersif avec A-Frame WebXR
- 📱 **PWA native** - Installation et utilisation hors-ligne
- 👨‍💼 **Interface admin** - Gestion complète des collections
- 🎨 **Design responsive** - Expérience optimisée PC/mobile/tablette

## 🚀 Démo en ligne

🌐 **Application déployée** : [https://digital-museum.fly.dev](https://digital-museum.fly.dev)

### Pages principales
- **Accueil & Galerie** : `/`
- **Visite virtuelle 3D** : `/visite-virtuelle`
- **Fiche œuvre (exemple)** : `/artwork/MASK_DIOLA_001`
- **Administration** : `/admin`

## 📋 Prérequis

- **PHP** 8.3+
- **Composer** 2.x
- **Node.js** 18+ & **npm**
- **MySQL** 8.0+ ou **SQLite**
- **Extension PHP** : GD, ZIP, PDO

## 🛠️ Installation

### 1. Cloner le projet
```bash
git clone https://github.com/your-org/digital-museum.git
cd digital-museum
```

### 2. Installer les dépendances
```bash
# Backend PHP
composer install

# Frontend Node.js
npm install
```

### 3. Configuration environnement
```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digital_museum
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Base de données
```bash
# Lancer les migrations
php artisan migrate

# Seeder les données de démo
php artisan db:seed

# Créer le lien symbolique storage
php artisan storage:link
```

### 5. Compiler les assets
```bash
# Mode développement
npm run dev

# Mode production
npm run build
```

### 6. Lancer l'application
```bash
php artisan serve
```

🎉 **Application accessible sur** : [http://localhost:8000](http://localhost:8000)

## 🏗️ Architecture

### Stack technique
```
Frontend:  Laravel Blade + Livewire + Alpine.js + Tailwind CSS
Backend:   PHP 8.3 + Laravel 11 + MySQL
3D/VR:     A-Frame WebXR + Three.js
Mobile:    PWA + Service Workers + WebApp Manifest
Audio:     SpeechSynthesis API + HTML5 Audio
QR:        SimpleSoftwareIO/QrCode
```

### Structure du projet
```
digital_museum/
├── app/
│   ├── Http/Controllers/       # Contrôleurs Laravel
│   ├── Livewire/              # Composants Livewire
│   ├── Models/                # Modèles Eloquent
│   └── Services/              # Services métier
├── resources/
│   ├── views/                 # Templates Blade
│   ├── css/                   # Styles Tailwind
│   └── js/                    # Scripts Alpine.js
├── public/
│   ├── storage/               # Fichiers médias
│   └── images/                # Assets statiques
├── database/
│   ├── migrations/            # Migrations DB
│   └── seeders/               # Données demo
├── config/
│   └── laravelpwa.php        # Configuration PWA
└── docker/                    # Configuration déploiement
```

## 📱 Fonctionnalités détaillées

### 🔍 Système QR Code
- **Génération automatique** de QR codes pour chaque œuvre
- **Routes intelligentes** : `/qr-code/{code}` → Génération SVG
- **Redirection fluide** : Scan → Fiche descriptive complète
- **Format optimisé** : SVG responsive haute qualité

### 🌍 Multilingue & Accessibilité
- **3 langues** : Français (défaut), Anglais, Wolof
- **Fallback intelligent** : Wolof → Français si traduction manquante
- **Synthèse vocale** adaptive par langue
- **Interface responsive** tactile optimisée

### 🎧 Système Audio
```javascript
// Synthèse vocale navigateur
speechSynthesis.speak(utterance);

// Sélection voix adaptée
voices.find(voice => voice.lang.startsWith(lang));
```

### 🎮 Visite 3D
- **A-Frame WebXR** pour environnement immersive
- **Navigation intuitive** WASD + souris/tactile
- **Œuvres interactives** avec animations au survol
- **Responsive** PC/mobile/casques VR

### 📱 PWA Native
```json
{
  "name": "Musée Digital des Civilisations Noires",
  "short_name": "MuséeDigital",
  "display": "standalone",
  "start_url": "/",
  "theme_color": "#D4AF37"
}
```

## 🚀 Déploiement

### Option 1 : Fly.io (Recommandé)
```bash
# Installer Fly CLI
curl -L https://fly.io/install.sh | sh

# Se connecter
fly auth login

# Lancer l'app
fly launch --name digital-museum

# Configurer MySQL
fly mysql create --name digital-museum-db
fly mysql attach digital-museum-db

# Déployer
fly deploy
```

📖 **Guide détaillé** : [deploy.md](deploy.md)

### Option 2 : Serveur traditionnel
```bash
# Serveur web (Apache/Nginx)
DocumentRoot /path/to/digital-museum/public

# PHP-FPM + Nginx recommandé pour performances
# Configuration SSL obligatoire pour PWA
```

## 👥 Utilisation

### Interface utilisateur
1. **Scanner QR code** sur œuvre physique/virtuelle
2. **Choisir langue** : FR/EN/WO
3. **Écouter description** audio adaptative
4. **Explorer contexte** historique et culturel
5. **Partager expérience** réseaux sociaux

### Interface administrateur
1. **Connexion** : `/admin`
2. **Gestion œuvres** : Ajouter/Modifier/Supprimer
3. **Upload médias** : Images, audio, vidéo
4. **Configuration QR** : Génération automatique
5. **Statistiques** : Analytics visiteurs

## 🧪 Tests

```bash
# Tests unitaires
php artisan test

# Tests fonctionnels
php artisan test --testsuite=Feature

# Tests navigateur (Laravel Dusk)
php artisan dusk
```

## 📊 Performance

### Métriques cibles
- **Page load** : <2s
- **PWA score** : >90/100
- **Mobile responsiveness** : 100%
- **Accessibility** : AA WCAG 2.1
- **SEO** : >95/100

### Optimisations
- **Lazy loading** images/assets
- **Service Worker** cache intelligent
- **CDN** optimisé pour médias
- **Gzip compression** activée
- **Database indexing** optimisé

## 🤝 Contribution

### Processus de développement
1. **Fork** le projet
2. **Créer branche** : `git checkout -b feature/amazing-feature`
3. **Commit changes** : `git commit -m 'Add amazing feature'`
4. **Push branch** : `git push origin feature/amazing-feature`
5. **Open Pull Request**

### Standards de code
- **PSR-4** autoloading
- **PSR-12** coding style
- **PHPDoc** documentation
- **Laravel conventions** naming

## 📄 License

Ce projet est sous licence **MIT**. Voir [LICENSE](LICENSE) pour plus de détails.

## 🏆 Équipe

Développé avec ❤️ par l'équipe **Digital Museum Solutions**

### Contact
- 📧 **Email** : contact@digital-museum.com
- 🌐 **Website** : [digital-museum.com](https://digital-museum.com)
- 🐙 **GitHub** : [github.com/digital-museum](https://github.com/digital-museum)

### Support
- 📚 **Documentation** : [docs.digital-museum.com](https://docs.digital-museum.com)
- 🐛 **Issues** : [GitHub Issues](https://github.com/digital-museum/issues)
- 💬 **Discussions** : [GitHub Discussions](https://github.com/digital-museum/discussions)

---

⭐ **Si ce projet vous plaît, n'hésitez pas à lui donner une étoile !**

*"Culture + Technologie = Avenir"* ✨