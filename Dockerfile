# Image pour PHP 8.2.0 avec Apache
FROM php:8.2.0-apache

# Environnement de travail
WORKDIR /var/www/html

# Mod Rewrite
RUN a2enmod rewrite

# Installation des dépendances (ne pas oublier mysql)
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    curl \
    libzip-dev \
    zip

# Installation de Node.js et npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP Extensions
RUN docker-php-ext-install gettext intl pdo_mysql gd zip
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copie des fichiers du projet
COPY . /var/www/html/

# Installer les dépendances PHP avec Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Installer les dépendances Node.js et compiler les assets
RUN npm install
RUN npm run build # ou npm run dev si en développement

# Créer le fichier .env si nécessaire
RUN cp .env.example .env

# Générer la clé d'application Laravel
RUN php artisan key:generate

# Définir les permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# (Optionnel) Optimisation pour la production
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache
