# Utiliser l'image de base PHP 8.2 (dernière version LTS)
FROM php:8.2-apache

# Installer les dépendances système requises pour Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le code source de l'application Laravel
COPY . /var/www/html

# Installer les dépendances Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Générer la clé de l'application Laravel
RUN php artisan key:generate

# Générer les fichiers de configuration de l'application Laravel
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan event:caches

# Configurer les autorisations
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80 pour le serveur web Apache
EXPOSE 80

# Démarrer le serveur Apache
CMD ["apache2-foreground"]