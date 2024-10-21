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

# Démarrer le serveur Reverb
echo "Starting Reverb server..."
php artisan reverb:start --debug
