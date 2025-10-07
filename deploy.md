# 🚀 Déploiement sur Fly.io

## Prérequis

1. **Installer Fly.io CLI** :
```bash
# Windows (PowerShell)
iwr https://fly.io/install.ps1 -useb | iex

# macOS/Linux
curl -L https://fly.io/install.sh | sh
```

2. **Se connecter à Fly.io** :
```bash
fly auth login
```

## Étapes de déploiement

### 1. Créer l'application Fly.io

```bash
# Lancer l'application
fly launch --name digital-museum --region cdg

# Répondre aux questions :
# - Would you like to copy its configuration to the new app? Yes
# - Would you like to deploy now? No (on configure d'abord)
```

### 2. Configurer la base de données MySQL

```bash
# Créer une base de données MySQL
fly mysql create --name digital-museum-db --region cdg

# Attacher la base de données à l'app
fly mysql attach digital-museum-db --app digital-museum
```

### 3. Configurer les variables d'environnement

```bash
# Variables obligatoires
fly secrets set APP_KEY=$(php artisan key:generate --show)
fly secrets set APP_URL=https://digital-museum.fly.dev
fly secrets set APP_ENV=production
fly secrets set APP_DEBUG=false

# Base de données (automatiquement configurée par fly mysql attach)
# Les variables DATABASE_URL sont automatiquement créées

# Optionnel : Configurer d'autres services
fly secrets set MAIL_MAILER=smtp
fly secrets set MAIL_HOST=your-smtp-host
fly secrets set MAIL_PORT=587
fly secrets set MAIL_USERNAME=your-email
fly secrets set MAIL_PASSWORD=your-password
```

### 4. Construire et déployer

```bash
# Construire l'image Docker localement (optionnel pour test)
docker build -t digital-museum .

# Déployer sur Fly.io
fly deploy

# Vérifier le statut
fly status
```

### 5. Migrations et configuration post-déploiement

```bash
# Lancer les migrations
fly ssh console --command "php artisan migrate --force"

# Créer le lien symbolique pour le storage
fly ssh console --command "php artisan storage:link"

# Seeder les données demo (optionnel)
fly ssh console --command "php artisan db:seed"

# Cache les configurations
fly ssh console --command "php artisan config:cache"
fly ssh console --command "php artisan route:cache"
fly ssh console --command "php artisan view:cache"
```

### 6. Configuration domaine personnalisé (optionnel)

```bash
# Ajouter un certificat SSL pour domaine custom
fly certs create your-custom-domain.com
fly certs show your-custom-domain.com
```

## Monitoring et maintenance

### Logs en temps réel
```bash
fly logs
```

### Monitoring ressources
```bash
fly status
fly vm status
```

### Scaling
```bash
# Scaler horizontalement
fly scale count 2

# Scaler verticalement
fly scale vm performance-1x
```

### Mise à jour
```bash
# Redéployer après modifications
fly deploy

# Rollback si problème
fly releases
fly rollback [VERSION]
```

## Structure des fichiers de déploiement

```
digital_museum/
├── fly.toml                 # Configuration Fly.io
├── Dockerfile              # Image Docker pour production
├── .dockerignore           # Fichiers à ignorer
├── docker/
│   ├── nginx.conf          # Configuration Nginx
│   └── supervisord.conf    # Configuration Supervisor
└── deploy.md              # Ce fichier d'instructions
```

## URLs de l'application déployée

- **Application principale** : https://digital-museum.fly.dev
- **Health check** : https://digital-museum.fly.dev/health
- **Galerie** : https://digital-museum.fly.dev/gallery
- **Admin** : https://digital-museum.fly.dev/admin
- **Visite 3D** : https://digital-museum.fly.dev/visite-virtuelle

## Troubleshooting

### Problèmes courants

1. **Application ne démarre pas** :
```bash
fly logs --app digital-museum
```

2. **Erreur de base de données** :
```bash
fly ssh console --command "php artisan migrate:status"
```

3. **Problème de permissions storage** :
```bash
fly ssh console --command "chmod -R 755 storage"
```

4. **Cache problématique** :
```bash
fly ssh console --command "php artisan cache:clear"
fly ssh console --command "php artisan config:clear"
```

### Commandes utiles

```bash
# Entrer en SSH dans l'app
fly ssh console

# Vérifier la configuration
fly ssh console --command "php artisan config:show"

# Voir les routes
fly ssh console --command "php artisan route:list"

# Test de connectivité DB
fly ssh console --command "php artisan tinker --execute='DB::connection()->getPdo();'"
```