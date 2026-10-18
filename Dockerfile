FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install -g npm@11
RUN npm install
COPY . .
RUN npm run build

FROM php:8.4-cli-alpine

RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    postgresql-dev \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_pgsql bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080