# Imagem base do PHP com extensões necessárias
FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia arquivos do projeto
COPY . .

# Instala dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Ajusta permissões de storage e bootstrap
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expõe a porta usada pelo Laravel
EXPOSE 8000

# Comando para rodar a aplicação
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
