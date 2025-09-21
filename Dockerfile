# Stage 1 - Build frontend assets (Vite + TailwindCSS)
# Stage 1 - frontend
FROM node:20 AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
COPY resources/ ./resources/
COPY vite.config.js ./
# Pass the VITE_ASSET_URL env to build
ARG VITE_ASSET_URL
ENV VITE_ASSET_URL=$VITE_ASSET_URL

RUN npm ci
RUN npm run build  # outputs /app/public/build


# Copy Node files and install dependencies
# COPY package.json package-lock.json ./
# RUN npm ci



# desparate check
# RUN ls -l /app/public/build
RUN ls -l /app/public
# RUN cp /app/public/.vite/manifest.json /app/public/build/manifest.json
# RUN cat /app/public/build/manifest.json
# RUN ls -l /app/dist
# Copy full project and build assets
# COPY . .
# RUN npm run build

# Copy built frontend assets from Stage 1


# Stage 2 - PHP backend (Laravel + Supabase)
FROM php:8.2-fpm AS backend

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo_pgsql mbstring zip

WORKDIR /var/www/html

COPY --from=frontend /app/public/build ./public/build
RUN cat /var/www/html/public/build/manifest.json
RUN ls -l /var/www/html/public/build/assets

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
# Copy app files
COPY . .

COPY --from=frontend /app/public/build ./public/build
# COPY --from=frontend /app/dist ./public/build #the problem :v

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

RUN ls -l /var/www/html/public/build
RUN php artisan storage:link
# Set permissions for storage and cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Set permissions (add public/build here)
RUN chown -R www-data:www-data storage bootstrap/cache public/build


# Expose Render port
EXPOSE 10000

# Run migrations, clear caches, then start Laravel
CMD php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan migrate --force \
    && php artisan serve --host=0.0.0.0 --port=10000 
    