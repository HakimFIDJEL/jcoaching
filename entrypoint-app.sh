#!/bin/bash

# Nettoyage des caches Laravel
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Rebuild des caches Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compilation des assets JS si nécessaire
npm run build

# Démarrer le worker Laravel en arrière-plan
echo "Starting Laravel queue worker..."
php artisan queue:work --daemon --sleep=3 --tries=3 --timeout=60 &

# Démarrer Apache au premier plan
echo "Starting Apache server..."
apache2-foreground
