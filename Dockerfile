FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpq-dev unzip git curl

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_pgsql

# Instalar composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html
COPY . .

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Ajustar permissões
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Rodar caches seguros
RUN php artisan config:cache
RUN php artisan route:cache
# Não rodar view:cache aqui, vai quebrar o build no Render Free

EXPOSE 8000

# Comando para iniciar o servidor
CMD php artisan serve --host=0.0.0.0 --port=8000
