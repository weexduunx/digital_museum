#!/bin/bash

# Script de déploiement automatisé pour Fly.io
# Usage: ./deploy.sh [environment]

set -e

# Configuration
APP_NAME="digital-museum"
DB_NAME="digital-museum-db"
REGION="cdg"

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Fonction pour afficher des messages colorés
print_message() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_step() {
    echo -e "${BLUE}[STEP]${NC} $1"
}

# Vérifier si Fly CLI est installé
check_fly_cli() {
    if ! command -v fly &> /dev/null; then
        print_error "Fly CLI n'est pas installé. Installation en cours..."
        curl -L https://fly.io/install.sh | sh
        export PATH="$HOME/.fly/bin:$PATH"
    fi
    print_message "Fly CLI est disponible"
}

# Vérifier l'authentification
check_auth() {
    if ! fly auth whoami &> /dev/null; then
        print_warning "Non connecté à Fly.io. Connexion requise..."
        fly auth login
    fi
    print_message "Connecté à Fly.io: $(fly auth whoami)"
}

# Générer la clé d'application si nécessaire
generate_app_key() {
    if [ ! -f .env ]; then
        print_warning "Fichier .env manquant. Copie depuis .env.example..."
        cp .env.example .env
    fi

    if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
        print_step "Génération de la clé d'application Laravel..."
        php artisan key:generate
    fi
    print_message "Clé d'application configurée"
}

# Construire les assets
build_assets() {
    print_step "Construction des assets frontend..."
    npm install
    npm run build
    print_message "Assets construits avec succès"
}

# Créer l'application Fly.io si elle n'existe pas
create_app() {
    if ! fly apps list | grep -q "$APP_NAME"; then
        print_step "Création de l'application Fly.io: $APP_NAME"
        fly launch --name "$APP_NAME" --region "$REGION" --no-deploy
        print_message "Application créée: $APP_NAME"
    else
        print_message "Application $APP_NAME existe déjà"
    fi
}

# Créer et attacher la base de données MySQL
setup_database() {
    # Vérifier si la base de données existe
    if ! fly mysql list | grep -q "$DB_NAME"; then
        print_step "Création de la base de données MySQL: $DB_NAME"
        fly mysql create --name "$DB_NAME" --region "$REGION"
        print_message "Base de données créée: $DB_NAME"
    else
        print_message "Base de données $DB_NAME existe déjà"
    fi

    # Attacher la base de données à l'application
    print_step "Attachement de la base de données à l'application..."
    fly mysql attach "$DB_NAME" --app "$APP_NAME" || true
    print_message "Base de données attachée"
}

# Configurer les variables d'environnement
setup_secrets() {
    print_step "Configuration des variables d'environnement..."

    # Récupérer la clé d'application depuis .env
    APP_KEY=$(grep "APP_KEY=" .env | cut -d '=' -f2)

    # Configurer les secrets
    fly secrets set \
        APP_KEY="$APP_KEY" \
        APP_ENV=production \
        APP_DEBUG=false \
        APP_URL="https://$APP_NAME.fly.dev" \
        LOG_CHANNEL=stderr \
        LOG_LEVEL=info \
        SESSION_DRIVER=database \
        SESSION_SECURE_COOKIE=true \
        --app "$APP_NAME"

    print_message "Variables d'environnement configurées"
}

# Déployer l'application
deploy_app() {
    print_step "Déploiement de l'application..."
    fly deploy --app "$APP_NAME"
    print_message "Déploiement terminé"
}

# Post-déploiement: migrations et optimisations
post_deploy() {
    print_step "Configuration post-déploiement..."

    # Lancer les migrations
    fly ssh console --app "$APP_NAME" --command "php artisan migrate --force"

    # Créer le lien symbolique storage
    fly ssh console --app "$APP_NAME" --command "php artisan storage:link"

    # Seeder les données de démo (optionnel)
    fly ssh console --app "$APP_NAME" --command "php artisan db:seed --force" || print_warning "Seeding échoué (normal si déjà fait)"

    # Cache les configurations pour les performances
    fly ssh console --app "$APP_NAME" --command "php artisan config:cache"
    fly ssh console --app "$APP_NAME" --command "php artisan route:cache"
    fly ssh console --app "$APP_NAME" --command "php artisan view:cache"

    print_message "Configuration post-déploiement terminée"
}

# Vérifier le déploiement
verify_deployment() {
    print_step "Vérification du déploiement..."

    # Vérifier le statut de l'application
    fly status --app "$APP_NAME"

    # Test de l'endpoint de santé
    APP_URL="https://$APP_NAME.fly.dev"
    if curl -s "$APP_URL/health" | grep -q "OK"; then
        print_message "✅ Application déployée avec succès!"
        print_message "🌐 URL: $APP_URL"
        print_message "🎨 Galerie: $APP_URL/gallery"
        print_message "🎮 Visite 3D: $APP_URL/visite-virtuelle"
        print_message "👨‍💼 Admin: $APP_URL/admin"
    else
        print_error "❌ Problème de déploiement détecté"
        print_message "Vérifiez les logs: fly logs --app $APP_NAME"
        exit 1
    fi
}

# Fonction principale
main() {
    print_message "🚀 Début du déploiement de Digital Museum sur Fly.io"

    check_fly_cli
    check_auth
    generate_app_key
    build_assets
    create_app
    setup_database
    setup_secrets
    deploy_app
    post_deploy
    verify_deployment

    print_message "🎉 Déploiement terminé avec succès!"
    print_message "📖 Consultez deploy.md pour plus d'informations"
}

# Gestion des erreurs
trap 'print_error "Erreur lors du déploiement. Vérifiez les logs."; exit 1' ERR

# Exécuter le script principal
main "$@"