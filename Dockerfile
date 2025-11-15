# Build stage
FROM composer:latest as build
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Frontend build stage
FROM node:24.11 as frontend
WORKDIR /app
COPY --from=build /app /app
RUN npm install && npm run build


# Production stage
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd \
    && a2enmod rewrite


      
# Configure Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files from build stage
COPY --from=build /app /var/www/html/

# Copy built assets from frontend stage
COPY --from=frontend /app/public/build /var/www/html/public/build

# Install Node.js and build assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build 

# Create and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && chown -R www-data:www-data storage bootstrap/cache public/build \
    && chmod -R 775 storage bootstrap/cache public/build 

# Copy .env if it doesn't exist
RUN if [ ! -f ".env" ]; then cp .env.example .env && php artisan key:generate; fi


RUN php artisan key:generate;

    
# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]