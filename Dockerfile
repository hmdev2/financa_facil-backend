FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev unzip git curl

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Ajustar permissões
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Rodar caches
RUN php artisan config:cache
RUN php artisan route:cache
# view:cache será rodado depois do deploy

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
